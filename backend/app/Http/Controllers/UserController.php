<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rules\Unique;

class UserController extends Controller
{
   public function register(Request $request)
   {

      try {

         $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'password' => Hash::make($request['password']),
            'matric_number' => $request['matric_number'],
            'email' => $request['email'],
            
         ]);

         $token = $user->createToken('match_token')->plainTextToken;

         return response()->json([
            "token" => $token,
            'message' => 'Welcome ' . $user->first_name . ' to venue master',
            'data' => $user->only(['matric_number', 'email'])
         ], 201);
      } catch (\Exception $e) {

         return response()->json([
            'error' => $e->getMessage()
         ], 404);
      }
   }

   public function login(Request $request)
   {
      try {
         $user = User::where('email', $request['email'])->first();
         if ($user == null) {
            return response()->json(['message' => 'user not found'], 404);
         } else {
            if (Hash::check($request->password, $user->password)) {

               $token = $user->createToken('match_token')->plainTextToken;

               return response()->json([
                  'token' => $token,
                  "user" => $user->only(['id', 'email']),
                  'message' => 'Welcome ' . $user['first_name']
               ], 200);
            } else {
               return response()->json(['message' => "Invalid credentials, please try again"], 401);
            }
         }
      } catch (\Exception $e) {
         return response()->json(["error" => $e->getMessage()], 404);
      }
   }

   public function getAll()
   {
      $user = User::with('matric_number')->get();
      return response()->json([
         'users' => $user
      ], 200);
   }

   public function oneUser(User $user)
   {
      if (!$user) {
         return response()->json(['message' => 'No existiing user'], 404);
      }

      return response()->json(['message' => $user], 200);
   }
}

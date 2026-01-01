<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\Venue;
use App\Models\User;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venues = Venue::with('faculty:id,faculty_name')->get();

        return response()->json([
            'data' => $venues,
            'message' => 'These are all venues'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $user = User::findOrFail($request['user_id']);

        $user = $request->user();

        $user->venues()->create([
            'faculty_id' => $request['faculty_id'],
            'name' => $request['name'],
            'location' => $request['location'],
            'features' => $request['features'],
        ]);

        return response()->json([
            'message' => 'New venue created',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Venue $venue)
    {
        if ($venue === null) {
            return response()->json([
                'message' => "No venue found"
            ], 404);
        }
        return response()->json([
            'message' => $venue->only(['name', 'faculty_id', 'location', 'features'])
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, Venue $venue)
{
    $data = $request->validate([
        'name' => [
            'required',
            'string',
            Rule::unique('venues', 'name')->ignore($venue->id),
        ],
        'location' => 'required|string',
        'features' => 'nullable|string',
    ]);

    $venue->update($data);

    return response()->json([
        'message' => 'Venue updated successfully',
        'data' => $venue,
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        $venue->delete();

        return response()->json([
            'message' => "venue deleted from list"
        ], 200);
    }
}

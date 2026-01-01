<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Venue;



class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculties = Faculty::with('venues')->withCount('venues')->get();

        return response()->json([
            'message' => "Faculty of Computing",
            "faculty" => $faculties
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $user = $request->user();

        $faculty = Faculty::create([
            'faculty_name' => $request['faculty_name'],
            'location' => $request['location'],
        ]);
        return response()->json([
            'message' => "New faculty created",
            'faculty' => $faculty->only(['id', 'faculty_name'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        return response()->json([
            "message" => $faculty
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faculty $faculty)
    {
        if (!$faculty) {
            return response()->json([
                'message' => "Faculty not found"
            ], 404);
        }

        $faculty->update([
            'faculty_name' => $request['faculty_name'],
            'location' => $request['location'],
        ]);

        return response()->json([
            'message' => "Faculty updated"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();

        return response()->json([
            'message' => "Faculty deleted"
        ], 200);
    }
}

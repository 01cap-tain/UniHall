<?php

use App\Http\Controllers\FacultyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('venue', VenueController::class);
    Route::apiResource('faculty', FacultyController::class);
});
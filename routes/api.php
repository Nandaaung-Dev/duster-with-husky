<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// User login route
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    return response()->json([
        'success' => false,
        'message' => 'Invalid credentials',
    ], 401);
});

// Get 5 random users (protected route)
Route::get('/user', function (Request $request) {
    return User::inRandomOrder()->take(5)->get();
})->middleware('auth:sanctum');

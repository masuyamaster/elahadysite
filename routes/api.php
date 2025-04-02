<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;

// API authentication routes
Route::prefix('auth')->group(function () {
    // Register user
    Route::post('register', [AuthController::class, 'register']);
    
    // Login user (email/username)
    Route::post('login', [AuthController::class, 'login']);

    // Google sign-up/sign-in
    Route::get('google', [GoogleAuthController::class, 'redirectToGoogle']);
    Route::get('google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
    
    // Forgot password (send reset link)
    Route::post('password/email', [AuthController::class, 'sendPasswordResetLink']);
    
    // Reset password
    Route::post('password/reset', [AuthController::class, 'resetPassword']);
});

// Protected routes for authenticated users
Route::middleware(['jwt.auth'])->group(function () {
    // Logout
    Route::post('logout', [AuthController::class, 'logout']);
    
    // Get the authenticated user
    Route::get('user', function (Request $request) {
        return response()->json(auth()->user());
    });
});

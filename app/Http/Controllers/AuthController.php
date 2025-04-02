<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // 🔹 Register User
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => implode(' ', array_map(fn($v) => implode(' ', $v), $validator->errors()->toArray())),
                'data' => null
            ], 400);
        }

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ]);
    }

    // 🔹 Login User
    public function login(Request $request)
{
    // Validate that either email or username is provided, along with password
    $credentials = $request->validate([
        'email' => 'required_without:username|email',
        'username' => 'required_without:email|string',
        'password' => 'required',
    ]);

    // Check if we received email or username, and then attempt to authenticate
    $credentialsToUse = [];
    
    if (!empty($credentials['email'])) {
        $credentialsToUse['email'] = $credentials['email'];
    } elseif (!empty($credentials['username'])) {
        $credentialsToUse['username'] = $credentials['username'];
    }

    // Attempt to authenticate with the given credentials
    $token = JWTAuth::attempt(array_merge($credentialsToUse, [
        'password' => $credentials['password']
    ]));

    if (!$token) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials',
            'data' => null
        ], 401);
    }

    return response()->json([
        'status' => true,
        'message' => 'Login successful',
        'data' => [
            'token' => $token,
            'user' => auth()->user()
        ]
    ]);
}


    // 🔹 Logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
            'data' => null
        ]);
    }

    // 🔹 Get Authenticated User
    public function userProfile()
    {
        return response()->json([
            'status' => true,
            'message' => 'User profile retrieved successfully',
            'data' => auth()->user()
        ]);
    }

    // 🔹 Refresh Token
    public function refresh()
    {
        return response()->json([
            'status' => true,
            'message' => 'Token refreshed successfully',
            'data' => [
                'token' => JWTAuth::refresh(JWTAuth::getToken())
            ]
        ]);
    }

    // 🔹 Forgot Password
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return response()->json([
            'status' => $status === Password::RESET_LINK_SENT,
            'message' => __($status),
            'data' => null
        ]);
    }

    // 🔹 Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return response()->json([
            'status' => $status === Password::PASSWORD_RESET,
            'message' => __($status),
            'data' => null
        ]);
    }

    public function invalidateAllTokens()
    {
        try {
            JWTAuth::setBlacklistEnabled(true); 
            JWTAuth::invalidate(JWTAuth::getToken());
    
            return response()->json([
                'status' => true,
                'message' => 'All sessions invalidated. All tokens are now unauthorized.',
                'data' => null
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to invalidate sessions',
                'data' => null
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:tblUser,username',
            'email' => 'required|email|unique:tblUser,email',
            'password' => 'required|min:6',
            'birthDate' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'token' => null
            ], 400);
        }

        DB::table('tblUser')->insert([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthDate' => $request->birthDate,
            'oAuthToken' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::where('username', $request->username)->first(); 
        

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found after registration',
                'token' => null
            ], 500);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'token' => $token
        ], 201);
    }

    // LOGIN
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first(); 

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
                'token' => null
            ], 401);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token
        ], 200);
    }

    // PROFILE
    public function profile()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile retrieved successfully',
            'data' => $user
        ], 200);
    }

    // LOGOUT
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully',
            'token' => null
        ]);
    }
}

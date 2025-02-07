<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Login Method
   
    
    public function login(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            $credentials = $request->only('email', 'password');
    
            // Attempt to authenticate
            if (Auth::attempt($credentials, $request->remember_me)) {
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful.',
                    'user' => $user,
                    'token' => $token,
                ]);
            }
    
            // Authentication failed
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid login credentials.',
            ]);
        } catch (\Throwable $e) {
            // Handle unexpected errors
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during login.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    


    // Register Method
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ]);
            }

            // Validation passed, proceed with your logic
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully',
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() || 'Something went wrong during registration.',
            ], 500);
        }
    }

    // Profile Method
    public function profile(Request $request)
    {
        try {
            return response()->json([
                'user' => $request->user()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?? 'Something went wrong while fetching the profile.',
            ], 500);
        }
    }

    // Logout Method
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'status' => 'success',
                'message' => 'Logged out successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?? 'Something went wrong while logout.',
            ], 500);
        }
    }
}

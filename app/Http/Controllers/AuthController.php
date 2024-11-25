<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $user = User::all();

        $response['data'] = $user;
        $response['message'] = "This is all user";
        $response['status_code'] = 200;
        return response()->json($response,200) ;
    }
    public function login(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Find the authenticated user
            $user = Auth::user();

            // Generate an API token
            $token = $user->createToken('myapptoken')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully']);
    }

}

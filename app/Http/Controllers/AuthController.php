<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register (Request $request) {
        $fields = $request->all([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);

        return [
            'user' => $user, 
            'token' => $token->plainTextToken
        ];
    }

    public function login (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($user->name);

            return [
                'user' => $user, 
                'token' => $token->plainTextToken
            ];
        }
        else if(!$user) {
            return response()->json([
                'message' => ''
            ], 404);
        }
        else {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 422);
        }
    }

    public function logout (Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'You are logged out.'
        ], 204);
    }
}

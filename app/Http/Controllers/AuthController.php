<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                "status" => true,
                "data" => [
                    'user' => $user,
                    'token' => $token,
                ],
                "message" => "Successful"
            ],200);
        }

        return response()->json([
            "status" => true,
            "data" => [],
            "message" => "Unauthorized"
        ],200);
    }
}

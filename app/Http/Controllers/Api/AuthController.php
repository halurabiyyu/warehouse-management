<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return ApiResponseHelper::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 'Login successful');
        }

        return ApiResponseHelper::error('Unauthorized', null, 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return ApiResponseHelper::success(null, 'Successfully logged out');
    }
}

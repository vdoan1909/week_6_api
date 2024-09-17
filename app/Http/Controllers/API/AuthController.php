<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;
        }

        return response()->json([
            'message' => 'Đăng ký thành công!',
            'data' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (
            Auth::attempt([
                'email' => $data['email'],
                'password' => $data['password']
            ])
        ) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(
                [
                    'message' => 'Đăng nhập thành công!',
                    'data' => $user,
                    'token_type' => 'Bearer',
                    'access_token' => $token
                ]
            );
        }
    }
}

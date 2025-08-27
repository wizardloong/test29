<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\UseCases\User\CreateUser\CreateUser;
use App\UseCases\User\CreateUser\CreateUserRequest;
use App\UseCases\User\LoginUser\LoginUser;

class AuthController extends Controller
{
    public function register(RegisterRequest $httpRequest, CreateUser $createUser)
    {
        try {
            $request = new CreateUserRequest(
                $httpRequest->name,
                $httpRequest->email,
                $httpRequest->password
            );

            $response = $createUser->execute($request);

            return response()->json($response->toArray(), 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function login(LoginRequest $request, LoginUser $loginUser)
    {
        try {
            $response = $loginUser->execute($request->email);

            return response()->json($response->toArray(), 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // удалить все токены
        return response()->json(['message' => 'Вы вышли из системы']);
    }
}

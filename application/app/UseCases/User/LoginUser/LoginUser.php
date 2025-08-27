<?php

namespace App\UseCases\User\LoginUser;

use App\Models\User;
use App\UseCases\User\CreateUser\CreateUserResponse;

class LoginUser
{
    public function execute(string $email): CreateUserResponse
    {
        $user =  User::where('email', $email)->first();

        $user->tokens()->delete();

        $token = $user->createToken('api_token')->plainTextToken;

        return new CreateUserResponse($user, $token);
    }
}

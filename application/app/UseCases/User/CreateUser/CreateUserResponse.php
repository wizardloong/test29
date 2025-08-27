<?php

namespace App\UseCases\User\CreateUser;

use App\Models\User;

class CreateUserResponse
{
    public function __construct(
        public User $user,
        public string $token = ''
    ) {}

    public function toArray(): array
    {
        return [
            'user' => $this->user,
            'token' => $this->token,
        ];
    }
}

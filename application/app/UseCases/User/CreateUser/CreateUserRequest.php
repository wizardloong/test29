<?php

namespace App\UseCases\User\CreateUser;

class CreateUserRequest
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}
}

<?php

namespace App\UseCases\User\CreateUser;

use App\Repositories\UserRepository;
use App\Models\User;

class CreateUser
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function execute(CreateUserRequest $request): CreateUserResponse
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        
        $this->userRepository->save($user);
        
        $token = $user->createToken('api_token')->plainTextToken;


        return new CreateUserResponse($user);
    }
}

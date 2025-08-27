<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;

class EloquentUserRepository implements UserRepository
{
    public function save(User $user): void
    {
        $user->save();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function emailExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    public function delete(int $id): void
    {
        User::destroy($id);
    }
}

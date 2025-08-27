<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepository
{
    public function save(User $user): void;
    public function findById(int $id): ?User;
    public function emailExists(string $email): bool;
    public function delete(int $id): void;
}

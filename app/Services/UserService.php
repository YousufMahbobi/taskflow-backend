<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService implements UserServiceInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }

    public function create(array $data): User
    {
        // Logic will be added later
    }

    public function update(User $user, array $data): User
    {
        // Logic will be added later
    }

    public function delete(User $user): void
    {
        // Logic will be added later
    }
}

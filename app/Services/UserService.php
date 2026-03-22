<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly AvatarUploadService $avatarUploadService) {}

    /**
     * Paginate users with customizable per-page value
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return User::paginate($perPage);
    }

    /**
     * Create a new user
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            if (isset($data['avatar'])) {
                $data['avatar'] = $this->avatarUploadService->upload($data['avatar']);
            }

            return User::create($data);
        });
    }

    /**
     * Update an existing user
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            if (isset($data['avatar'])) {
                if ($user->avatar) {
                    $this->avatarUploadService->delete($user->avatar);
                }
                $data['avatar'] = $this->avatarUploadService->upload($data['avatar']);
            }

            $user->update($data);

            return $user;
        });
    }

    /**
     * Delete a user
     */
    public function delete(User $user): void
    {
        DB::transaction(function () use ($user) {
            if ($user->avatar) {
                $this->avatarUploadService->delete($user->avatar);
            }

            $user->delete();
        });
    }
}

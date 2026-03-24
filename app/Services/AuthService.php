<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials): ?User
    {
        if (!Auth::attempt($credentials)) {
            return null;
        }

        $user = $this->user();

        if (!$user || !$user->status) {
            $this->logout();
            return null;
        }

        return $user;
    }

    public function user(): ?User
    {
        return Auth::user();
    }

    public function logout(): void
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}

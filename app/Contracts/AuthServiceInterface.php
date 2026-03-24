<?php

namespace App\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    public function login(array $credentials): ?User;
    public function logout(): void;
    public function user(): ?User;
}

<?php

namespace App\Http\Controllers;

use App\Contracts\AuthServiceInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->login($request->validated());

        if (!$user) {
            return ApiResponse::error(
                message: 'Invalid credentials',
                code: 'INVALID_CREDENTIALS',
                status: 401
            );
        }

        return ApiResponse::success(
            message: 'Login successful',
            data: new UserResource($user),
            code: 'LOGIN_SUCCESS'
        );
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return ApiResponse::success(
            message: 'Logged out successfully',
            data: null,
            code: 'LOGOUT_SUCCESS'
        );
    }

    public function me(): JsonResponse
    {
        $user = $this->authService->user();

        if (!$user) {
            return ApiResponse::error(
                message: 'User not authenticated',
                code: 'UNAUTHENTICATED',
                status: 401
            );
        }

        return ApiResponse::success(
            message: 'User retrieved successfully',
            data: new UserResource($user),
            code: 'USER_RETRIEVED'
        );
    }
}

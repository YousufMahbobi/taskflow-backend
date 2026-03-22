<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {}
    /**
     * Display a paginated list of users.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->integer('per_page', 10);

        $users = $this->userService->paginate($perPage);

        return ApiResponse::success(
            message: 'Users fetched successfully',
            data: UserResource::collection($users)->resolve(),
            code: 'USERS_FETCHED',
            status: 200,
            meta: [
                'current_page' => $users->currentPage(),
                'last_page'    => $users->lastPage(),
                'per_page'     => $users->perPage(),
                'total'        => $users->total(),
            ]
        );
    }

    /**
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create(
            $request->validated()
        );

        return ApiResponse::success(
            message: 'User created successfully',
            data: new UserResource($user),
            code: 'USER_CREATED',
            status: 201
        );
    }

    /**
     * Display a single user.
     * Route Model Binding guarantees existence.
     */
    public function show(User $user): JsonResponse
    {
        return ApiResponse::success(
            message: 'User fetched successfully',
            data: new UserResource($user),
            code: 'USER_FETCHED'
        );
    }

    /**
     * Update the specified user.
     */
    public function update(User $user, UpdateUserRequest $request): JsonResponse
    {
        $updatedUser = $this->userService->update(
            $user,
            $request->validated()
        );

        return ApiResponse::success(
            message: 'User updated successfully',
            data: new UserResource($updatedUser),
            code: 'USER_UPDATED'
        );
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userService->delete($user);

        return ApiResponse::success(
            message: 'User deleted successfully',
            data: null,
            code: 'USER_DELETED'
        );
    }
}

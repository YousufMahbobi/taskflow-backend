<?php

use App\Support\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Validation Errors (422)
        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error(
                    message: 'Validation failed',
                    code: 'VALIDATION_ERROR',
                    errors: $e->errors(),
                    status: 422
                );
            }
        });

        // Model Not Found (404)
        $exceptions->render(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error(
                    message: 'Resource not found',
                    code: 'RESOURCE_NOT_FOUND',
                    status: 404
                );
            }
        });

        // HTTP Exceptions (401, 403, 404, etc.)
        $exceptions->render(function (HttpExceptionInterface $e, $request) {
            if ($request->expectsJson()) {
                $status = $e->getStatusCode();

                $message = match ($status) {
                    401 => 'Unauthenticated',
                    403 => 'Forbidden',
                    404 => 'Resource not found',
                    default => 'HTTP error'
                };

                $code = match ($status) {
                    401 => 'UNAUTHENTICATED',
                    403 => 'FORBIDDEN',
                    404 => 'RESOURCE_NOT_FOUND',
                    default => 'HTTP_EXCEPTION'
                };

                return ApiResponse::error(
                    message: $message,
                    code: $code,
                    status: $status
                );
            }
        });

        // Fallback (500 - Server Error)
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error(
                    message: config('app.debug') ? $e->getMessage() : 'Server Error',
                    code: 'SERVER_ERROR',
                    status: 500
                );
            }
        });
    })->create();

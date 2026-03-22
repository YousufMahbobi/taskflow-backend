<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class ApiResponse
{
     /**
     * Return a success response.
     *
     * @param string $message
     * @param mixed|null $data
     * @param string $code
     * @param int $status
     * @param array $meta
     * @return JsonResponse
     */
    public static function success(
        string $message,
        mixed $data = null,
        string $code = 'SUCCESS',
        int $status = 200,
        array $meta = []
    ): JsonResponse {

        if ($data instanceof JsonResource) {
            $data = $data->resolve();
        } elseif($data instanceof \Illuminate\Support\Collection) {
            $data = $data->toArray();
        }

        $response = [
            'success' => true,
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ];

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $status);
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @param string $code
     * @param array $errors
     * @param int $status
     * @return JsonResponse
     */
    public static function error(
        string $message,
        string $code = 'ERROR',
        array $errors = [],
        int $status = 400
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
            'code' => $code,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}

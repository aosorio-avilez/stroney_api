<?php

/**
 * Helper functions
 */

use Illuminate\Http\JsonResponse;

if (!function_exists('config_path')) {
    /**
     * Get the path to the config folder
     *
     * @return string
     */
    function config_path()
    {
        return realpath(__DIR__ . '/..') . '/config';
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the path to the public folder
     *
     * @return string
     */
    function public_path()
    {
        return base_path() . '/public';
    }
}

if (!function_exists('log_path')) {
    /**
     * Get the path to the application folder
     *
     * @return string
     */
    function log_path()
    {
        return storage_path() . '/logs';
    }
}

if (!function_exists('resource_path')) {
    /**
     * Get the path to the application folder
     *
     * @return string
     */
    function resource_path()
    {
        return base_path() . '/resource';
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get the path to the application folder
     *
     * @return string
     */
    function storage_path()
    {
        return base_path() . '/storage';
    }
}

if (!function_exists('jsonResponse')) {
    function jsonResponse(int $status, $data = null): JsonResponse
    {
        return response()->json($data, $status);
    }

    function jsonErrorResponse(
        int $status,
        string $message,
        string $error,
        ?array $errors = null
    ): JsonResponse {
        return response()->json([
            'error_code' => $error,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}

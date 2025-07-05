<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($code = 200, $message = 'Success', $key = "data",  $data = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            $key => $data
        ], $code);
    }

    public static function error($message = 'Error', $errors = [], $code = 400): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}

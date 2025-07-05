<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = null, $message = 'Success', $code = 200, $key = "data")
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            $key => $data
        ], $code);
    }

    public static function error($message = 'Error', $errors = [], $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}

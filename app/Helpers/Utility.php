<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Utility
{
    public static function successResponse($message, $data = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $message??'',
            'data' => $data,
        ], 200);
    }
    public static function exceptionResponse(\Exception $exception): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $exception->getMessage().' in line '.$exception->getLine().' in file '.$exception->getFile(),
            'data' => null,
        ], 400);
    }

    public static function validationResponse(Validator $validator): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $validator->errors()->first(),
            'data' => $validator->errors(),
        ], 400);
    }

    public static function errorResponse($message = ''): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => null,
        ], 400);
    }

    public static function generateUID(): string
    {
        return Str::random(8);
    }
}

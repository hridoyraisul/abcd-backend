<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Utility
{
    public static function successResponse($message, $data = null, $code = 200, $links = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $message??'',
            'data' => $data,
            'links' => $links,
        ], $code);
    }
    public static function exceptionResponse(\Exception $exception): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $exception->getMessage().' in line '.$exception->getLine().' in file '.$exception->getFile(),
            'data' => null,
        ], 400);
    }

    public static function validationResponse($validator): \Illuminate\Http\JsonResponse
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

    public static function getPagination($pagination_data): array
    {
        return [
            "first"         => $pagination_data->url(1),
            "last"          => $pagination_data->url($pagination_data->lastPage()),
            "prev"          => $pagination_data->previousPageUrl(),
            "next"          => $pagination_data->nextPageUrl(),
            "current_page"  => $pagination_data->currentPage(),
            "per_page"      => $pagination_data->perPage(),
            "total_item" 	=> $pagination_data->total(),
            "total_page"    => $pagination_data->lastPage(),
        ];
    }
}

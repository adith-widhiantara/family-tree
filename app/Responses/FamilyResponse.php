<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;
use function response;

class FamilyResponse
{
    /**
     * @param $message
     * @param $data
     * @param int $code
     * @param null $redirect
     * @return JsonResponse
     */
    public static function json($message, $data, int $code = 200, $redirect = NULL): JsonResponse
    {
        $response = [
            'message' => $message,
            'data' => $data,
        ];

        if ($redirect) {
            $response['redirect'] = $redirect;
        }

        return response()->json($response, $code);
    }
}
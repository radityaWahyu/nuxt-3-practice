<?php

namespace App\Traits;

use Carbon\Carbon;

trait ApiResponse
{
    public function errorServerResponse($message)
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], 500);
    }

    public function successResponse($message, $data = null)
    {
        return response()->json(['message' => $message, 'data' => $data]);
    }

    public function successCollectionResponse($message, $data = null)
    {
        return response()->json($data);
    }

    public function notFoundResponse($message)
    {
        return response()->json([
            'message' => $message
        ], 404);
    }

    public function loggedResponse($user)
    {
        return response()->json($user, 200);
    }

    public function cekHari()
    {
        $today = Carbon::now()->locale('id');
        $today->settings(['formatFunction' => 'translatedFormat']);
        $dayName = strtolower($today->format('l'));

        return $dayName;
    }
}

<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param $token
     * @param User $user
     * @return JsonResponse
     */
    protected function respondWithToken($token, User $user = null)
    {
        return response()->json([
            'status' => 1,
            'data' => [
                'user' => $user ?? [],
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard()->factory()->getTTL() * 60
            ]
        ], 200);
    }


    /**
     * @param array $data
     * @param int $httpStatus
     * @return JsonResponse
     */
    protected function responseSuccess($data, $httpStatus = 200) {
        return response()->json([
            'status' => 1,
            'data' => $data ?? []
        ], $httpStatus);
    }


    /**
     * @param string $msg
     * @param int $httpStatus
     * @return JsonResponse
     */
    protected function responseMsg($msg, $httpStatus = 200) {
        return response()->json([
            'status' => 1,
            'message' => $msg
        ], $httpStatus);
    }


    /**
     * @param $msg
     * @param int $httpStatus
     * @return JsonResponse
     */
    protected function responseError($msg, $httpStatus = 400) {
        return response()->json([
            'status' => 0,
            'message' => $msg
        ], $httpStatus);
    }
}

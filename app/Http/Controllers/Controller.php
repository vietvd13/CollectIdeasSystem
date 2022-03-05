<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param int|null $code
     * @param null $data
     * @param null $message
     * @param null $internalMessage
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJson(int $code = null, $data = null, $message = null, $internalMessage = null)
    {
        return response()->json([
            "status" => $code,
            "data" => $data,
        ], $code);
    }

    /**
     * @param int|null $code
     * @param null $message
     * @param null $internalMessage
     * @param null $dataError
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJsonError(int $code = null, $message = null, $internalMessage = null, $dataError = null)
    {
        return response()->json([
            "status" => $code,
            "message" => $message,
            "internal_message" => $internalMessage,
            "data_error" => $dataError
        ], $code);
    }


    /**
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJsonEx($e)
    {
        return $e;
    }
}

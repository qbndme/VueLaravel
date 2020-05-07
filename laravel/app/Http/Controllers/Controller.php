<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static function successResponse($data = "")
    {
        self::send_response(['code' => 20000, 'data' => $data]);
    }

    protected static function failResponse($code, $message = "")
    {
        self::send_response(['code' => $code, 'message' => $message]);
    }

    private static function send_response($data)
    {
        response()->json($data)->send();
        exit;
    }
}

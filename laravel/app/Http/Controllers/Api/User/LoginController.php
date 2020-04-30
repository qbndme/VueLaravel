<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    { 
        $data = [
            'code' => 20000,
            'data' => [
                'token' => 'b1323509c456d86540dfd5db0f1a21331591492669',
            ],
        ];
        return response()->json($data);
    }
}

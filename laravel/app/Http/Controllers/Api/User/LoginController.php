<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
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
        if (!$request->filled(['username', 'password'])) {
            self::failResponse(50008, 'Login failed, param error.');
        }

        $name = $request->input('username');
        $password = $request->input('password');
        $info = AdminUser::select('password', 'remember_token')->where('name', $name)->first();

        if (!isset($info) || $info['password'] != md5($password)) {
            self::failResponse(50008, 'Account or password are incorrect.');
        }
        self::successResponse(['token' => $info['remember_token']]);
    }
}

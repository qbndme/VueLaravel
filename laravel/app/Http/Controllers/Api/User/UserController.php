<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use DB;

class UserController extends Controller
{
    public function logout()
    {
        self::successResponse('success');
    }

    public function info()
    {
        if (!request()->filled('token')) {
            self::failResponse(50008, 'Login failed, param error.');
        }

        $token = request()->input('token');

        $info = AdminUser::select('name', 'avatar', 'role_id')->where('remember_token', $token)->first();
        if (!isset($info)) {
            self::failResponse(50008, 'Login failed, Login failed, unable to get user details.');
        }
       
        // DB::enableQueryLog();
        $roles = AdminUser::find($info['role_id'])->adminRole;
        // dump(DB::getQueryLog());
       
        $roles = $roles ? $roles->toArray() : [ 'name' => 'new', 'introduction'=>'I new one'];

        $data = [
            'name' => $info['name'],
            'avatar' => $info['avatar'],
            'introduction' => $roles['introduction'],
            'roles' => [$roles['name']],
        ];

        self::successResponse($data);
    }
}

<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Model\User;

class UserController extends Controller
{
    public function info()
    {
        $users = User::find(1)->toArray();
        $data = [
            'code' => 20000,
            'data' => [
                'roles' => ['admin', 'editor'],
                'introduction' => 'I am a super administrator',
                'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
                'name' => 'Super Admin',
            ],
        ];
        return response()->json($data);
    }
}

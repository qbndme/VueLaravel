<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;

class AdminController extends Controller
{
    public function getList()
    {
        if (!request()->filled(['page', 'limit'])) {
            self::failResponse(40008, 'failed, param error.');
        }
        $limit = request()->input('limit');
        $sort = request()->input('sort');

        $query = AdminUser::query();
        $query = $query->select('id', 'name', 'nickname', 'tell', 'email', 'status', 'crate_time', 'last_login_time')->where('status', '!=', 2);
        if (request()->has('name')) {
            $query = $query->where('name', 'like', '%' . request()->input('name') . '%');
        }
        if (!empty($sort)) {
            $query = $query->orderByRaw(sort2orderby($sort));
        }
        // \DB::enableQueryLog();
        $queryData = $query->paginate($limit);
        // dump(\DB::getQueryLog());die;
        if (!isset($queryData)) {
            self::failResponse(40008, 'there is empty list');
        }

        $queryData = $queryData->toArray();

        $data['list'] = $queryData['data'];
        $data['total'] = $queryData['total'];

        self::successResponse($data);
    }

    public function addAddmin()
    {
        //必传参数
        if (!request()->filled(['name', 'password'])) {
            self::failResponse(40008, 'failed, param error.');
        }
        $input = request()->all();
        $ad = new AdminUser();
        foreach ($input as $key => $value) {
            if (!empty($value) && $key != 'operator') {
                if ($key == 'password') {
                    $tmp = 'open-passwd';
                    $ad->$key = md5($value);
                    $ad->$tmp = $value;
                } else {
                    $ad->$key = $value;
                }

            }
        }
        $tmp = 'remember_token';
        $ad->$tmp = md5($input['name']);
        $res = $ad->save();
        if (!$res) {
            self::failResponse(40008, 'insert error.');
        }

        $data = ['id' => $ad->id];
        if (!isset($input['status'])) {
            $data['status'] = 1;
        }
        self::successResponse($data);
    }

    
    public function modifyStatus()
    {
        if (!request()->filled(['id', 'status'])) {
            self::failResponse(40008, 'failed, param error.');
        }
        $id = request()->input('id');
        $status = request()->input('status');
        $user = AdminUser::find($id);
        if (!isset($user) || $user->status == $status || $status < 0 || $status > 2) {
            self::failResponse(40008, 'failed, param error.');
        }
        $user->status = $status;
        $user->save();
        self::successResponse('success');
    }

    public function updateAddmin()
    {
        //必传参数
        if (!request()->filled('id')) {
            self::failResponse(40008, 'failed, param error.');
        }
        $input = request()->all();
        $ad = AdminUser::find($input['id']);
        foreach ($input as $key => $value) {
            if ($value !== '' && $key != 'operator') {
                if ($key == 'password') {
                    $tmp = 'open-passwd';
                    $ad->$key = md5($value);
                    $ad->$tmp = $value;
                } else {
                    $ad->$key = $value;
                }

            }
        }
        $res = $ad->save();
        if (!$res) {
            self::failResponse(40008, 'update error.');
        }

        self::successResponse('success');
    }
}

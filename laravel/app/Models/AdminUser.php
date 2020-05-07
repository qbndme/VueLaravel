<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'admin_users';
    
    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 获取与用户相关的角色。
     */
    public function adminRole()
    {
        return $this->hasOne('App\Models\AdminRole','id','role_id');
    }

}

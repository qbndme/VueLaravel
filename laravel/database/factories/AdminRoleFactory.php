<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\AdminRole;
use Faker\Generator as Faker;

$factory->define(AdminRole::class, function (Faker $faker) {
    return [
        'code' => 1,
        'name' => 'admin',
        'status' => 1,
        'introduction' => '我是管理员',
        'operator' => '超级管理员',
        'operate_ip' => '127.0.0.1',
        'crate_time' => $faker->unixTime('now'),
        'update_time' => $faker->unixTime('now'),
    ];
});

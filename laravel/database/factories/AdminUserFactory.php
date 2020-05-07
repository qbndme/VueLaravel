<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\AdminUser;
use Faker\Generator as Faker;

$factory->define(AdminUser::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->firstName,
        'nickname' => $faker->name,
        'password' => md5('123456'),
        'open-passwd' => '123456',
        'tell' => '186****1111',
        'email' => $faker->freeEmail,
        'remember_token' => md5($faker->unique()->md5),
        'last_login_time' => $faker->unixTime( 'now'),
        'last_login_ip' => $faker->localIpv4,
        'crate_time' => $faker->unixTime('now'),
        'update_time' => $faker->unixTime('now'),
    ];
});

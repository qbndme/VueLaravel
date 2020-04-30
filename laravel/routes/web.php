<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::match(['get', 'post'], '/user/login', 'Api\User\LoginController');
Route::match(['get', 'post'], '/user/info', 'Api\User\UserController@info');

//学习

//路由参数
// Route::any('any/{id?}', function ($id = null) {
//     return 'any' . $id;
// })->where('id','[A-Za-z0-9]+');

// Route::any('any/{id?}/{name?}', function ($id = null,$name='') {
//     return 'any-id-' . $id.'-name-'.$name;
// })->where(['id'=>'[0-9]','name'=>'[A-Za-z0-9]+']);

//路由别名
// Route::any('asany1',['as'=>'as',function (){
//     return route('as');
// }]);

//路由群组
// Route::group(['prefix' => 'member'], function () {
//     //实际路由为/member/asany1
//     Route::any('asany1', ['as' => 'as', function () {
//         return route('as');//route助手函数取路由地址
//     }]);
// });

//控制器结合
Route::any('/user/login', [
    'uses' => 'Api\User\LoginController',
    'as' => 'userLogin',
]);

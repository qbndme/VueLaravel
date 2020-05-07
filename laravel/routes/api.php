<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'user'], function () {
    Route::any('/login', 'Api\User\LoginController');
    Route::any('/info', 'Api\User\UserController@info');
    Route::any('/logout', 'Api\User\UserController@logout');

});

Route::group(['prefix' => 'admin'], function () {
    Route::any('/getList', 'Api\User\AdminController@getList');
    Route::any('/modifyStatus', 'Api\User\AdminController@modifyStatus');
    Route::any('/addAddmin', 'Api\User\AdminController@addAddmin');
    Route::any('/updateAddmin', 'Api\User\AdminController@updateAddmin');
});

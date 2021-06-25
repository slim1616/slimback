<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:api'], function(){



    Route::get('user/all','UserController@all');
    Route::get('getuser','UserController@getUser');
    Route::post('user/update','UserController@update');
    Route::post('user/add','UserController@add');
    Route::get('user/{id}','UserController@getSingleUser');
    Route::post('user/edit','UserController@editSingleUser');
    Route::post('user/changepass','UserController@changePassword');
    Route::post('user/addavatar','UserController@updateAvatar');
    Route::post('user/addmyavatar','UserController@updateMyAvatar');
    Route::get('roles','UserController@rolesList');


    Route::get('settings/{id}', 'SettingController@get');
    Route::put('settings', 'SettingController@update');
});

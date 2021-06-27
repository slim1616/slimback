<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');
Route::post('social_auth', 'Api\Auth\SocialAuthController@socialAuth');
Route::post('password/email', 'Api\Auth\LoginController@forgot');

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



Route::get('formules', 'FormuleController@list');
Route::get('dataformules', 'FormuleController@data');
Route::get('formules/{id}', 'FormuleController@get');
Route::post('formules', 'FormuleController@create');
Route::put('formules/{id}', 'FormuleController@update');
Route::delete('formules/{id}', 'FormuleController@delete');

Route::get('companies', 'CompanyController@list');
Route::get('datacompanies', 'CompanyController@data');
Route::get('companies/{id}', 'CompanyController@get');
Route::post('companies', 'CompanyController@create');
Route::put('companies/{id}', 'CompanyController@update');
Route::delete('companies/{id}', 'CompanyController@delete');

Route::get('abonnements', 'AbonnementController@list');
Route::get('dataabonnements', 'AbonnementController@data');
Route::get('abonnements/{id}', 'AbonnementController@get');
Route::post('abonnements', 'AbonnementController@create');
Route::put('abonnements/{id}', 'AbonnementController@update');
Route::delete('abonnements/{id}', 'AbonnementController@delete');

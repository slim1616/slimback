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


    Route::get('user/company','UserController@UsersCompany');
    Route::post('user/adduc','UserController@adduserCompany');
    Route::post('user/cedit','UserController@editSingleComanyUser');
    Route::delete('user/{id}', 'UserController@destroy');

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
    Route::get('mesemplacements', 'EmplacementController@MesEmplacements');
    
    Route::get('enquetes', 'EnqueteController@list');
    Route::get('dataenquetes', 'EnqueteController@data');
    Route::get('enquetes/{id}', 'EnqueteController@get');
    Route::get('enquetes/front/{id}', 'EnqueteController@getFront'); 
    
    
    Route::post('enquetes', 'EnqueteController@create');
    Route::put('enquetes/{id}', 'EnqueteController@update');
    Route::delete('enquetes/{id}', 'EnqueteController@delete');

    Route::get('dataemplacements', 'EmplacementController@data');
    Route::get('emplacements/{id}', 'EmplacementController@get');
    Route::post('emplacements', 'EmplacementController@create');
    Route::put('emplacements/{id}', 'EmplacementController@update');
    Route::delete('emplacements/{id}', 'EmplacementController@delete');

    Route::get('company/abonnements', 'AbonnementController@CompanyAbs');
    Route::get('abonnements', 'AbonnementController@list');
    Route::get('dataabonnements', 'AbonnementController@data');
    Route::get('abonnements/{id}', 'AbonnementController@get');
    Route::post('abonnements', 'AbonnementController@create');
    Route::put('abonnements/{id}', 'AbonnementController@update');
    Route::delete('abonnements/{id}', 'AbonnementController@delete');

    Route::get('companies', 'CompanyController@list');
    Route::get('datacompanies', 'CompanyController@data');
    Route::get('companies/{id}', 'CompanyController@get');
    Route::post('companies', 'CompanyController@create');
    Route::put('companies/{id}', 'CompanyController@update');
    Route::delete('companies/{id}', 'CompanyController@delete');


    Route::post('/savequestions', 'QuestionController@saveQuestions'); 
    Route::post('/enquestions', 'QuestionController@QuestionsByEnquete'); 
    Route::delete('/delquestion/{id}', 'QuestionController@deleteSection'); 
    
    
    
});
Route::post('enquetes/addresponse', 'EnqueteController@addResponse'); 
Route::get('enquetes/myresponses/{unique}', 'EnqueteController@getResponses'); 
Route::get('enquetes/hresponses/{id}', 'EnqueteController@getHistorique'); 
Route::post('enquetes/filterreponsesbydates', 'EnqueteController@getHistoriqueBySource'); 





Route::get('formules', 'FormuleController@list');
Route::get('dataformules', 'FormuleController@data');
Route::get('formules/{id}', 'FormuleController@get');
Route::post('formules', 'FormuleController@create');
Route::put('formules/{id}', 'FormuleController@update');
Route::delete('formules/{id}', 'FormuleController@delete');





Route::get('emplacements', 'EmplacementController@list');






Route::get('questions', 'QuestionController@list');
Route::get('dataquestions', 'QuestionController@data');
Route::get('questions/{id}', 'QuestionController@get');
Route::post('questions', 'QuestionController@create');
Route::put('questions/{id}', 'QuestionController@update');
Route::delete('questions/{id}', 'QuestionController@delete');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');
Route::post('social_auth', 'Api\Auth\SocialAuthController@socialAuth');
Route::post('password/email', 'Api\Auth\LoginController@forgot');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'auth:api'], function(){


    Route::get('user/company','UserController@UsersCompany');
    Route::post('user/adduc','UserController@adduserCompany');
    Route::post('user/cedit','UserController@editSingleComanyUser');
    Route::delete('user/{id}', 'UserController@destroy');
    Route::get('user/companyusers/{id}','UserController@UsersByCompany');
    
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
    Route::post('companies/addlogo', 'CompanyController@addLogo');
    Route::post('companies', 'CompanyController@create');
    Route::put('companies/{id}', 'CompanyController@update');
    Route::delete('companies/{id}', 'CompanyController@delete');


    Route::post('/savequestions', 'QuestionController@saveQuestions'); 
    Route::post('/enquestions', 'QuestionController@QuestionsByEnquete'); 
    Route::delete('/delquestion/{id}', 'QuestionController@deleteSection'); 
    
    Route::get('bornes', 'BorneController@list');

    Route::get('bornes/statshomebornes', 'BorneController@HomeStats');
    Route::get('databornes', 'BorneController@data');
    Route::get('bornes/{id}', 'BorneController@get');
    Route::post('bornes', 'BorneController@create');
    Route::put('bornes/{id}', 'BorneController@update');
    Route::delete('bornes/{id}', 'BorneController@delete');
    
    Route::get('bornesreponses/{id}', 'BornesreponseController@get');
    Route::delete('bornesreponses/{id}', 'BornesreponseController@delete');


    Route::get('datacompagnes', 'CompagneController@data');
    Route::get('compagnes/{id}', 'CompagneController@get');
    Route::post('compagnes', 'CompagneController@create');
    Route::put('compagnes/{id}', 'CompagneController@update');
    Route::delete('compagnes/{id}', 'CompagneController@delete');
    Route::get('compagnes', 'CompagneController@list');


    Route::get('emplacements', 'EmplacementController@list');
    
});


Route::post('borne/filterreponses', 'BornesreponseController@filter');
Route::post('borne/monthreponses', 'BornesreponseController@getDataMonth');


Route::post('addresponses', 'BornesreponseController@MassAdd');
Route::post('bornesreponses', 'BornesreponseController@create');


Route::post('enquetes/front/{id}', 'EnqueteController@getFrontMobile'); 
Route::get('enquetes/frontstart/{id}', 'EnqueteController@getFrontInit');
Route::post('enquetes/privatefront/{id}', 'EnqueteController@getFrontWithPassword');

Route::post('enquetes/addresponse', 'EnqueteController@addResponse'); 
Route::get('enquetes/myresponses/{unique}', 'EnqueteController@getResponses'); 
Route::get('enquetes/hresponses/{id}', 'EnqueteController@getHistorique'); 
Route::post('enquetes/filterreponsesbydates', 'EnqueteController@getHistoriqueBySource'); 





Route::get('formules/actifs', 'FormuleController@formulesActifs');
Route::get('formules', 'FormuleController@list');
Route::get('dataformules', 'FormuleController@data');
Route::get('formules/{id}', 'FormuleController@get');
Route::post('formules', 'FormuleController@create');
Route::put('formules/{id}', 'FormuleController@update');
Route::delete('formules/{id}', 'FormuleController@delete');



// get emplacement by code
Route::post('emplacements/newpass', 'EmplacementController@newpass'); 

// qr code
Route::post("generateqrcode", "QRcodeController@generate");






Route::get('questions', 'QuestionController@list');
Route::get('dataquestions', 'QuestionController@data');
Route::get('questions/{id}', 'QuestionController@get');
Route::post('questions', 'QuestionController@create');
Route::put('questions/{id}', 'QuestionController@update');
Route::delete('questions/{id}', 'QuestionController@delete');



Route::get('bornesreponses', 'BornesreponseController@list');





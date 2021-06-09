<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:api'], function(){


    //historique
    Route::post('filterhistorique', 'AccessController@filterHistorique');
    Route::post('filterpointage', 'EmployeController@filterPointage');
    Route::post('filterhistoriquebyemp/{employe_id}', 'AccessController@filterHistoriqueByEmploye');

    
    
    Route::post('affectemployes', 'AccessController@massAffect');
    Route::post('employesaffectes', 'AccessController@getEmployesAffectes');
    Route::post('employeseffaceaccess', 'AccessController@effaceEmployesAccess');
    Route::get('access/employe/{id}', 'AccessController@getSingleEmployeAccess');
    Route::post('getcurrentemployesaccess', 'AccessController@getCurrentAffectaions');
    Route::get('getemployes/{departement_id}', 'EmployeController@getEmployesByDepartement');
    

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
    

    Route::get('employedepartement/{id}','EmployeController@employesDepartement');
    Route::get('employes','EmployeController@getList');
    Route::get('employe/{id}','EmployeController@getEmploye');
    Route::post('employe/update','EmployeController@update');
    Route::post('employe/add','EmployeController@add');
    Route::post('employe/efface','EmployeController@efface');
    Route::post('employe/addemployeavatar','EmployeController@addEmployeAvatar');
    Route::get('departementslist','EmployeController@departementsList');
    Route::post('affectemplois','EmployeController@affectMassEmplois');
    
    
    
    

    Route::get('batimentsall', 'BatimentController@all');
    Route::get('batiments', 'BatimentController@list');
    Route::get('batiments/{id}', 'BatimentController@get');
    Route::post('batiments', 'BatimentController@create');
    Route::put('batiments/{id}', 'BatimentController@update');
    Route::delete('batiments/{id}', 'BatimentController@delete');

    Route::get('zones', 'ZoneController@list');
    Route::get('zones/{id}', 'ZoneController@get');
    Route::post('zones', 'ZoneController@create');
    Route::put('zones/{id}', 'ZoneController@update');
    Route::delete('zones/{id}', 'ZoneController@delete');
    Route::post('zonesbybatiment', 'ZoneController@zonesByBatiment');

    Route::get('portesbyzone/{zone_id}', 'PorteController@portesByZone');
    Route::get('portes', 'PorteController@list');
    Route::get('portes/{id}', 'PorteController@get');
    Route::post('portes', 'PorteController@create');
    Route::put('portes/{id}', 'PorteController@update');
    Route::delete('portes/{id}', 'PorteController@delete');

    Route::get('timezones', 'TimezoneController@list');
    Route::get('timezones/{id}', 'TimezoneController@get');
    Route::post('timezones', 'TimezoneController@create');
    Route::put('timezones/{id}', 'TimezoneController@update');
    Route::delete('timezones/{id}', 'TimezoneController@delete');
    
    Route::get('departements', 'DepartementController@list');
    Route::get('departements/{id}', 'DepartementController@get');
    Route::post('departements', 'DepartementController@create');
    Route::put('departements/{id}', 'DepartementController@update');
    Route::delete('departements/{id}', 'DepartementController@delete');    


    Route::get('settings/{id}', 'SettingController@get');
    Route::put('settings', 'SettingController@update');
});

Route::get('sendporte/{porte_id}', 'ZkController@sendUsersToPorte'); //envoyer users à un device (single porte)
Route::get('sendusertoportes/{employe_id}', 'ZkController@sendUserToPortes'); //envoyer 1 user aux portes affecté (employe single)
Route::post('sendusersbyporteandtimezone', 'ZkController@AffectUsersToPorte'); //envoyer users aux portes affecté (affectation)

//timezones
Route::get('gettimezonesbyeporte/{porte_id}', 'ZkController@getTimezonzsByPorte'); //collectez Timezones d'une porte
//attendance
Route::get('attendancefromporte/{porte_id}', 'ZkController@getAttendaznceByPorte'); //collectez l'historique des acces
Route::get('collectelistuseres/{porte_id}', 'ZkController@CollectUsersFromPorte'); // collectez les users d'une porte
Route::get('importelogsdevices', 'ZkController@importelogsdevices'); // collectez les users d'une porte
Route::get('importelogsstandalone', 'ZkController@importelogsstandalone'); // collectez les users d'une porte

//efface
Route::get('effacetouslogs/{porte_id}', 'ZkController@EffaceTousLogs'); // Effacez tous les logs d'une porte
Route::get('effacetoususers/{porte_id}', 'ZkController@EffaceTousUsers'); // Effacez les users d'une porte
Route::get('effacetoustimezones/{porte_id}', 'ZkController@EffaceTousTimezones'); // Effacez les users d'une porte


//Set Time
Route::get('settimedevice/{porte_id}', 'ZkController@SetTimeDevice'); // Set Time
//test connection
Route::post('testcnxdevice','ZkController@TestConnection');



<?php
// dd(extension_loaded('redis'));
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('rtl', 'ZkController@Rtl');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::group( ['middleware' => 'auth' ], function(){
    Route::post('file-import', 'UserController@fileImport')->name('file-import');
    Route::get('importusers', function(){
        return view('excel.import');
    });

    Route::get('/', function () {
        return view('layouts.main');
    });
    
    Route::get('/historique', function () {
        return view('layouts.main');
    });
    Route::get('/editprofile', function () {
        return view('layouts.main');
    });
    Route::get('/users', function () {
        return view('layouts.main');
    });
    Route::get('/edituser/{id}', function () {
        return view('layouts.main');
    });
    Route::get('/passwordchange', function () {
        return view('layouts.main');
    });

    Route::get('/affectationemploi', function () {
        return view('layouts.main');
    });
    Route::get('/employes', function () {
        return view('layouts.main');
    });
    Route::get('/pointage', function () {
        return view('layouts.main');
    });
    
    Route::get('/settings', function () {
        return view('layouts.main');
    });
    Route::get('/affectationsaccess', function () {
        return view('layouts.main');
    });
    Route::get('/rapportaffectations', function () {
        return view('layouts.main');
    });

    Route::get('/timezones', function () {
        return view('layouts.main');
    });
    Route::get('/createtimezones', function () {
        return view('layouts.main');
    });
    Route::get('/timezones/{id}', function () {
        return view('layouts.main');
    });
    
    Route::get('batiments', function () {
        return view('layouts.main');
    });
    Route::get('createbatiments', function () {
        return view('layouts.main');
    });
    Route::get('batiments/{id}', function () {
        return view('layouts.main');
    });

    Route::get('departements', function () {
        return view('layouts.main');
    });
    Route::get('createdepartements', function () {
        return view('layouts.main');
    });
    Route::get('departements/{id}', function () {
        return view('layouts.main');
    });
    

    Route::get('/zones', function () {
        return view('layouts.main');
    });
    Route::get('/createzones', function () {
        return view('layouts.main');
    });
    Route::get('/zones/{id}', function () {
        return view('layouts.main');
    });
    
    
    Route::get('/portes', function () {
        return view('layouts.main');
    });
    Route::get('/createportes', function () {
        return view('layouts.main');
    });
    Route::get('/portes/{id}', function () {
        return view('layouts.main');
    });
    
    Route::get('/ajoutemploye', function () {
        return view('layouts.main');
    });
    Route::get('/adduser', function () {
        return view('layouts.main');
    });
    
    Route::get('/editemploye/{id}', function () {
        return view('layouts.main');
    });
    
    
    Route::get('/404', function () {
        return view('layouts.main');
    });
    
});


// Route::get('/home', 'HomeController@index')->name('home');

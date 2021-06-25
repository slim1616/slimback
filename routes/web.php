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
    

    Route::get('/users', function () {
        return view('layouts.main');
    });
    Route::get('/edituser/{id}', function () {
        return view('layouts.main');
    });
    Route::get('/passwordchange', function () {
        return view('layouts.main');
    });

    
    
    Route::get('/settings', function () {
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

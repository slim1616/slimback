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
Auth::routes();

Route::get('login/{provider}', 'SocialController@redirect');
Route::get('login/{provider}/callback', 'SocialController@callback');

Route::get('my-demo-mail','MailController@myDemoMail');

Route::get('chart', 'BornesreponseController@chart');

Route::group( ['middleware' => 'auth' ,'prefix' => 'admin' ], function(){
   
    Route::get('/users', function () {
        return view('layouts.main');
    });
    Route::get('/companies', function () {
        return view('layouts.main');
    });
    Route::get('/companies/{id}', function () {
        return view('layouts.main');
    })->name('companie');
    Route::get('/formules', function () {
        return view('layouts.main');
    });
    Route::get('/abonnements', function () {
        return view('layouts.main');
    });
    Route::get('/createabonnements', function () {
        return view('layouts.main');
    });
    Route::get('/abonnements/{id}', function () {
        return view('layouts.main');
    });
    Route::get('/createformules', function () {
        return view('layouts.main');
    });
    
    Route::get('/edituser/{id}', function () {
        return view('layouts.main');
    });
    Route::get('/passwordchange', function () {
        return view('layouts.main');
    });

    
    Route::get('/editprofile', function () {
        return view('layouts.main');
    })->name('editprofile');
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
    Route::get('{any}', function () {
        return view('layouts.main');
    })->where('any', '.*');
    
    Route::get('/', function () {
        return view('layouts.main');
    })->name('home');
});


Route::get('/', 'HomeController@accueil')->name('accueil');

Route::get('/enquete/{id}','HomeController@passEnquete')->name('passenquete');
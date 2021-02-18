<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/' , function() {
        return 'INDEX';  
})->name('front.index');

Route::group([
    'prefix' => '/admin',
    'as' => 'admin.',
    'middleware' => 'auth'
], function () {
    Route::get('/', 'DashboardController')->name('dashboard');
    Route::resource('/categories', 'CategoryController');
    Route::resource('/products', 'ProductController');
    Route::resource('/orders', 'OrderController');
    Route::resource('/clients', 'ClientController');
});



Auth::routes();

// Client Auth Routes


Route::get('/clients/register' , 'Auth\RegisterController@clientRegisterationForm')->name('client-register-form');
Route::post('/clients/register', 'Auth\RegisterController@registerClient')->name('client-register');
Route::get('/clients/login', 'Auth\loginController@clientLoginForm')->name('client-login-form');
Route::post('/clients/login', 'Auth\loginController@clientLogin')->name('client-login');
Route::post('/clients/logout', 'Auth\loginController@clientLogout')->name('client-logout');




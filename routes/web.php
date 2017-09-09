<?php

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', 'Auth\LoginController@showLoginForm');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/user/profile/{id}', 'UserController@showProfile')->name('user-profile');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

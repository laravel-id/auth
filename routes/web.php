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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('signup', 'SignupController@form')->name('signup.form');
Route::post('store', 'SignupController@store')->name('signup.store');
Route::get('verify', 'SignupController@verify')->name('signup.verify');

Route::get('signin', 'SigninController@form')->name('signin.form');
Route::post('attempt', 'SigninController@attempt')->name('signin.attempt');

Route::get('/home', 'HomeController@index');

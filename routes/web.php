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

Route::get('/', 'HomeController@home')->name('home');

Route::get('/login', 'UserController@getLogin')->name('user.get.login');

Route::post('/login', 'UserController@postLogin')->name('user.post.login');

Route::get('/register', 'UserController@getRegister')->name('user.get.register');

Route::post('/register', 'UserController@postRegister')->name('user.post.register');

Route::get('/users', 'UserController@getListUser')->middleware('auth');

Route::get('/recharge', 'RechargeController@getRecharge');
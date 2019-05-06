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

Route::post('/user/logout', 'UserController@logout')->name('user.logout');

Route::get('/active', 'UserController@active')->name('user.active');

Route::group(['prefix' => 'recharge', 'middleware' => 'auth'], function(){

	Route::get('/', 'RechargeController@getRecharge')->name('user.recharge');

	Route::post('/', 'RechargeController@postRecharge')->name('user.post.recharge');

	Route::get('/url_return_vnpay', 'RechargeController@responseDataVnp');

	Route::get('/url_return_momo', 'RechargeController@responseDataMoMo');

	Route::get('/success', 'RechargeController@success')->name('recharge.success');

	Route::get('/fail', 'RechargeController@fail')->name('recharge.fail');
});

Route::post('/recharge/url_notify', 'RechargeController@responseDataMoMoNotify');

Route::group(['prefix' => 'transfer', 'middleware' => 'auth'], function(){

	Route::get('create', 'TransferController@create')->name('transfer.create');

	Route::post('create', 'TransferController@postCreate')->name('transfer.post.create');

	Route::get('verify', 'TransferController@verify')->name('transfer.verify');

	Route::post('verify', 'TransferController@postVerify')->name('transfer.post.verify');

	Route::get('/success', 'TransferController@success')->name('transfer.success');
});

Route::group(['prefix' => 'withdrawal', 'middleware' => 'auth'], function(){

	Route::get('create', 'WithdrawalController@create')->name('withdrawal.create');

	Route::post('create', 'WithdrawalController@postCreate')->name('user.post.withdrawal');

	Route::get('/url_return_vnpay', 'WithdrawalController@responseDataVnp');

	Route::get('/success', 'WithdrawalController@success')->name('withdrawal.success');

	Route::get('/fail', 'WithdrawalController@fail')->name('withdrawal.fail');
});

Route::group(['prefix' => 'store'], function() {

	Route::get('/service/{services_id}', 'ServiceController@listItem')->name('service.item');

	Route::post('/buy/service', 'ServiceController@postBuyItem')->name('service.buy.item');

	Route::get('/service/item/list-amount', 'ServiceController@listAmount')->name('service.item.list-amount');
});
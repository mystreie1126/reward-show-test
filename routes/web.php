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



Route::resource('order','orderController',[
		'except' => ['show','edit','update','destroy','create']
]);

Route::POST('/rewardOnline','rewardController@rewardOnline')->name('online_reward');
Route::POST('/rewardPos','rewardController@rewardPos')->name('pos_reward');
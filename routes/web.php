<?php
use Illuminate\Http\Request;

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

// Route::resource('order','orderController',[
// 		'except' => ['show','edit','update','destroy','create']
// ]);


// Route::get('/','orderController@showOrder')->name('homepage');
// Route::post('/order','orderController@store')->name('postOrder');
// Route::post('/voucher','voucherController@get_voucher')->name('get_voucher');

// Route::POST('/rewardOnline','rewardController@rewardOnline')->name('online_reward');
// Route::POST('/rewardPos','rewardController@rewardPos')->name('pos_reward');
// Route::post('/ref','searchRef@search')->name('search');
// Route::POST('/voucher','voucherController@index')->name('view_voucherOrder');
// Route::POST('/pickup','voucherController@pickup')->name('pickup');

//Route::get('/order', 'HomeController@index')->name('home');

Route::get('/testa',function(){


});

Route::get('/',function(){
	return view('index');
});
Route::get('/test','voucherController@test');
Route::get('/neworder','OrderController@newOrder');
Route::post('/createvoucher','voucherController@createPosVoucher');
Route::post('/vouchertopos','voucherController@send_voucher_to_rockpos');
Route::post('/pullvoucher','voucherController@pull_online_voucher_rockpos');
Route::post('/voucher_results','voucherController@voucher_results');
Route::post('/checkreward','voucherController@check_reward');

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

Route::get('/', function() {
    return view('home');
});

Route::group(['prefix' => 'lab'], function() {
    Route::get('/', 'LabController@index');
    Route::get('select', 'LabController@select');
    Route::get('checkout', 'CheckoutController@index');
    Route::post('checkout', 'CheckoutController@pay');
});

Route::group(['prefix' => 'admin'], function() {
    Route::get('/', 'AdminController@index');
});

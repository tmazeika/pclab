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

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('home');
});

Route::group(['prefix' => 'admin'], function() {
    Route::get('/', 'AdminController@index');

    Route::get('create/{table}', 'AdminController@showCreate');
    Route::get('update/{table}/{id}', 'AdminController@showUpdate');

    Route::get('delete/{table}/{id}', 'AdminController@delete');

    Route::post('create/{table}', 'AdminController@create');
    Route::post('update/{table}/{id}', 'AdminController@update');

});

Route::group(['prefix' => 'build'], function() {
    Route::get('/', 'BuildController@index');
    Route::get('preset', 'BuildController@showPreset');

    Route::group(['prefix' => 'custom'], function() {
        Route::get('/', 'BuildController@showCustom');
        Route::get('select', 'BuildController@customSelect');
    });
});

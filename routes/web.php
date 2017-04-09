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

Route::group(['prefix' => 'admin'], function() {
    Route::get('/', 'AdminController@index');

    Route::get('create/{model}', 'AdminController@showCreate');
    Route::get('update/{model}/{id}', 'AdminController@showUpdate');

    Route::get('delete/{model}/{id}', 'AdminController@delete');

    Route::post('create/{model}', 'AdminController@create');
    Route::post('update/{model}/{id}', 'AdminController@update');

    Route::get('update-compatibilities', 'AdminController@updateCompatibilities');

});

Route::group(['prefix' => 'build'], function() {
    Route::get('/', 'BuildController@index');
    Route::get('preset', 'BuildController@showPreset');

    Route::group(['prefix' => 'custom'], function() {
        Route::get('/', 'BuildController@showCustom');
        Route::get('select', 'BuildController@customSelect');
    });
});

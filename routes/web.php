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

    Route::get('create/{table}/{id}', 'AdminController@create');
    Route::get('update/{table}/{id}', 'AdminController@update');
    Route::get('delete/{table}/{id}', 'AdminController@delete');
});

Route::group(['prefix' => 'build'], function() {
    Route::get('/', function() {
        return view('build.index');
    });

    Route::get('custom', function() {
        return view('build.custom');
    });

    Route::get('preset', function() {
        return view('build.preset');
    });
});

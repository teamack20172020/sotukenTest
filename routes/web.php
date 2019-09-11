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

Route::middleware(['cors'])->group(function () {
    Route::options('placelist', function () {
        return response()->json();
    });

    //Route::post('placelist', 'GooglePlacesAPIController@index');
    Route::get('placelist', 'GooglePlacesAPIController@index');
    Route::get('rote', 'GoogleDirectionsAPIController@index');
});
//Route::resource('/test', 'GooglePlacesAPIController');
//Route::get('test', 'GooglePlacesAPIController@index');
//Route::match(["get", "options"], "test", "GooglePlacesAPIController@index");
<?php

use Illuminate\Support\Facades\Route;

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

Route::group([ "prefix" => "contratos" ], function() {
	Route::post( "", 'ContratosController@create');
	Route::get( "", 'ContratosController@index');
});

Route::group([ "prefix" => "imoveis" ], function() {
	Route::post( "", 'ImoveisController@create');
	Route::get( "", 'ImoveisController@index');
	Route::delete( "{id}", 'ImoveisController@delete');
});

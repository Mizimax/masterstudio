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

	Route::get('/', 'HomeController@index');
	Route::get('/profile', 'Auth\LoginController@me');
	Route::get('/activity', 'ActivityController@index');
	Route::get('/activity/{name}', 'ActivityController@show');
	Route::get('/master', 'MasterController@index');
	Route::get('/master/{name}', 'MasterController@show');
	Route::get('/studio', 'StudioController@index');
	Route::get('/studio/{name}', 'StudioController@show');
	Route::get('/become', 'MasterController@create');
	Route::get('/content/activity', 'ContentController@activity');

	Auth::routes();
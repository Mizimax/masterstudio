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
	Route::get('/user/{userId}', 'UserController@show');
	Route::post('/user/{userId}', 'UserController@follow');
	Route::get('/activity', 'ActivityController@index');
	Route::get('/activity/{name}', 'ActivityController@show');
	Route::get('/master', 'MasterController@index');
	Route::get('/master/{name}', 'MasterController@show');
	Route::get('/studio', 'StudioController@index');
	Route::get('/studio/{name}', 'StudioController@show');
	Route::get('/become', 'MasterController@create');

	Route::get('/content/activity/{offset}', 'ContentController@activity');
	Route::get('/content/timeline/{category}/{userId}', 'ContentController@timeline');
	Route::get('/content/achievement/{category}/{userId}', 'ContentController@achievement');

	Route::post('/api/category/{categoryId}', 'CategoryController@addInterest');

	Auth::routes();
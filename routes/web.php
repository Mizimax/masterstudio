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
	Route::get('/activity', function () {
		return view('activity');
	});
	Route::get('/activity/{name}', function () {
		return view('activity-detail');
	});
	Route::get('/master', function () {
		return view('master');
	});
	Route::get('/master/{name}', function ($name) {
		return view('master-detail', ['master' => ['master_name' => $name]]);
	});
	Route::get('/studio', function () {
		return view('studio');
	});
	Route::get('/studio/{name}', function () {
		return view('studio-detail');
	});
	Route::get('/become', function () {
		return view('become');
	});
	Route::get('/content/activity/all', function () {
		//?start=6&offset=12
		return view('components.activity-grid-card', ['activities' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]]);
	});

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
	Route::post('/logout/back', 'UserController@getLogout');
	Route::get('/user/{userId}', 'UserController@show');
	Route::get('/activity', 'ActivityController@index');
	Route::get('/activity/search', 'ActivityController@search');
	Route::get('/activity/{name}', 'ActivityController@show');
	Route::get('/master', 'MasterController@index');

	Route::get('/master/{id}', 'MasterController@show');
	Route::get('/studio', 'StudioController@index');
	Route::get('/studio/{id}', 'StudioController@show');
	Route::get('/become', 'MasterController@create');

	Route::group(['middleware' => 'auth'], function () {
		Route::post('/activity/{id}/payment', 'PaymentController@payment');
		Route::post('/user/{userId}', 'UserController@follow');
		Route::post('/master/{userId}', 'MasterController@follow');
		Route::delete('/master/{id}/gallery/{picId}', 'MasterController@delGallery');
		Route::post('/master/{id}/gallery', 'MasterController@addGallery');
		Route::post('/user/{userId}/profile/{action}', 'UserController@editProfile');
		Route::delete('/user/{userId}/gallery/{picId}', 'UserController@delGallery');
		Route::post('/user/{userId}/gallery', 'UserController@addGallery');
		Route::post('/studio/{id}', 'StudioController@follow');
		Route::post('/add/more', 'UserController@more');
		Route::get('/content/story/{category}/{userId}', 'ContentController@story');
		Route::get('/content/timeline/{category}/{userId}', 'ContentController@timeline');
		Route::get('/content/allActivity', 'ContentController@allActivity');
		Route::get('/content/follow/master', 'ContentController@follow');
		Route::post('/api/category/{categoryId}', 'CategoryController@addInterest');
		Route::delete('/api/category/{categoryId}', 'CategoryController@removeInterest');
		Route::post('/studio/{id}/review', 'StudioController@review');
		Route::post('/activity/{id}/story', 'UserController@story');
		Route::post('/activity/{id}/comment', 'ActivityController@comment');
		Route::post('/activity/{id}/pin', 'ActivityController@pin');
		Route::post('/activity/{id}/unpin', 'ActivityController@unpin');
	});
	Route::group(['middleware' => 'master'], function () {
		Route::get('/dashboard', 'DashboardController@index');
	});
	Route::get('/content/master/search', 'MasterController@search');
	Route::get('/content/master/category', 'MasterController@category');
	Route::get('/content/activity/{offset}', 'ContentController@activity');
	Route::get('/content/activities', 'ContentController@activities');
	Route::get('/content/achievement/{category}/{userId}', 'ContentController@achievement');
	Route::get('/content/map', 'ContentController@map');
	Route::get('/content/studio/{id}/master', 'ContentController@studioMaster');

	Auth::routes();
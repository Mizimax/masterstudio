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
	Route::post('/become', 'MasterController@create');

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

		Route::delete('/dashboard/story/{storyId}', 'DashboardController@removeStory');
	});
	Route::group(['middleware' => 'admin'], function () {
		Route::get('/dashboard/user/add', 'DashboardController@addUser');
		Route::post('/dashboard/user', 'DashboardController@createUser');
		Route::delete('/dashboard/user/{userId}', 'DashboardController@removeUser');
		Route::get('/dashboard/master/add', 'DashboardController@addMaster');
		Route::post('/dashboard/master', 'DashboardController@createMaster');
		Route::delete('/dashboard/master/{masterId}', 'DashboardController@removeMaster');
		Route::get('/dashboard/studio/add', 'DashboardController@addStudio');
		Route::post('/dashboard/studio', 'DashboardController@createStudio');
		Route::delete('/dashboard/studio/{studioId}', 'DashboardController@removeStudio');
		Route::get('/dashboard/activity/add', 'DashboardController@addActivity');
		Route::post('/dashboard/activity', 'DashboardController@createActivity');
		Route::delete('/dashboard/activity/{activityId}', 'DashboardController@removeActivity');
		Route::get('/dashboard/story', 'DashboardController@stories');
	});
	Route::group(['middleware' => ['MasterOrAdmin']], function () {
		Route::get('/dashboard', 'DashboardController@index');
		Route::get('/dashboard/studio', 'DashboardController@studios');
		Route::get('/dashboard/studio/{studioId}', 'DashboardController@studio');
		Route::post('/dashboard/studio/{studioId}', 'DashboardController@editStudio');
		Route::get('/dashboard/user', 'DashboardController@users');
		Route::get('/dashboard/user/{userId}', 'DashboardController@user');
		Route::post('/dashboard/user/{userId}', 'DashboardController@editUser');
		Route::get('/dashboard/master', 'DashboardController@masters');
		Route::get('/dashboard/master/{masterId}', 'DashboardController@master');
		Route::post('/dashboard/master/{masterId}', 'DashboardController@editMaster');
		Route::get('/dashboard/activity', 'DashboardController@activities');
		Route::get('/dashboard/activity/{activityId}', 'DashboardController@activity');
		Route::post('/dashboard/activity/{activityId}', 'DashboardController@editActivity');
	});

	Route::get('/content/master/search', 'MasterController@search');
	Route::get('/content/master/category', 'MasterController@category');
	Route::get('/content/activity/{offset}', 'ContentController@activity');
	Route::get('/content/activities', 'ContentController@activities');
	Route::get('/content/achievement/{category}/{userId}', 'ContentController@achievement');
	Route::get('/content/map', 'ContentController@map');
	Route::get('/content/studio/{id}/master', 'ContentController@studioMaster');

	Auth::routes();
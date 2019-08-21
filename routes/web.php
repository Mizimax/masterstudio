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
Route::get('/activity', function (){
    return view('activity');
});
Route::get('/master', function (){
    return view('master');
});
Route::get('/studio', function (){
    return view('studio');
});
Route::get('/become', function (){
    return view('become');
});



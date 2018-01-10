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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create'); 
Route::get('/threads/{channels}/{thread}', 'ThreadsController@show');
Route::post('/threads', 'ThreadsController@store');
Route::get('/threads/{channels}', 'ThreadsController@index'); 
Route::post('/threads/{channels}/{thread}/replies', 'RepliesController@store');

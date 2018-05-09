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
Route::delete('threads/{channels}/{thread}', 'ThreadsController@destroy'); 
Route::post('/threads', 'ThreadsController@store');
Route::get('/threads/{channels}', 'ThreadsController@index'); 
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');


Route::post('/threads/{channels}/{thread}/replies', 'RepliesController@store');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');

Route::get('/channels/create', 'ChannelsController@create');
Route::get('/channels', 'ChannelsController@show');
Route::post('/channels/create', 'ChannelsController@store')->name('CreateChannels');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');


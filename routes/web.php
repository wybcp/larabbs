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

Route::get('/','PagesController@home')->name('home');

Auth::routes();

//查看log
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs');
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);
Route::resource('topics', 'TopicsController', ['only' => ['index',  'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}',"TopicsController@show")->name('topics.show');
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

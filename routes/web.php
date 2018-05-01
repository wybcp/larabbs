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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/','StaticPagesController@index')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
//查看log
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs');

Route::resource('users','UsersController');

Route::get('/login','UsersController@login')->name('login');
Route::post('/login','UsersController@checkLogin')->name('login');
Route::delete('/logout','UsersController@logout')->name('logout');





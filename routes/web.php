<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);

		Route::get('/noticias', 'App\Http\Controllers\NewsController@index');
		Route::get('/noticia/create', 'App\Http\Controllers\NewsController@create');
		Route::post('/noticia', 'App\Http\Controllers\NewsController@store');
		Route::get('/noticia/editar/{id}', 'App\Http\Controllers\NewsController@edit');
		Route::post('/noticia/{id}', 'App\Http\Controllers\NewsController@update');
		Route::get('/delete/noticia/{id}', 'App\Http\Controllers\NewsController@delete');

		Route::post('/search', 'App\Http\Controllers\NewsController@search');
		Route::get('/users', 'App\Http\Controllers\NewsController@users');
		Route::get('/user/{id}', 'App\Http\Controllers\UserController@delete');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

//Route::get('/noticias', [App\Http\Controllers\NoticiasController::class, 'index'])->name('noticias');
//Route::get('/noticias', 'App\Http\Controllers\NoticiasController@index')->name('noticias')->middleware('auth');
//Route::get('/noticias', 'App\Http\Controllers\NewsController@index');

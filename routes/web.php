<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/home', 'HomeController@index')->name('home');


#Route::get('/{anypath}', 'HomeController@index')->where('path', '.*');

// backend catagory route

Route::post('/add-category', 'Admin\CategoryController@store');
Route::get('/categories', 'Admin\CategoryController@index');
Route::get('/remove-categories/{slug}', 'Admin\CategoryController@destroy');
Route::get('/show-categories/{slug}', 'Admin\CategoryController@show');
Route::post('/update-category', 'Admin\CategoryController@update');
Route::post('/categories/remove-items', 'Admin\CategoryController@removeItems');
Route::post('/categories/change-status', 'Admin\CategoryController@changeStatus');

// backend post route  

Route::post('/add-post', 'Admin\PostController@store');
Route::get('/get-post', 'Admin\PostController@index');
Route::get('/remove-post/{slug}', 'Admin\PostController@destroy');
Route::get('/show-post/{slug}', 'Admin\PostController@show');
Route::post('/update-post', 'Admin\PostController@update');
Route::post('/posts/remove-items', 'Admin\PostController@removeItems');
Route::post('/posts/change-status', 'Admin\PostController@changeStatus');

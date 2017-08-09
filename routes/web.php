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
Route::get('/test', function () {
    return view('test');
});
Route::post('/save-file', 'PhotoController@saveFile')->name('save');



Route::resource('fluffiness', 'FluffinessController');
Route::resource('category', 'CategoryController');
Route::resource('brand', 'BrandController');
Route::resource('colour', 'ColourController');
Route::resource('size', 'SizeController');
Route::resource('item', 'ItemController');




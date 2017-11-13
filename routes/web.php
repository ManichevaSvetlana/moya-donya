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
    $id = \App\Http\Controllers\ItemController::getId();
    $photo = \Illuminate\Support\Facades\DB::table('item_photos');
    $photo->insert([
        'item_id' => $id,
        'photo_id' => 19,
        'is_main' => '1'
    ]);
    dd(\App\Item::findOrFail($id)->photo);
});


Route::resource('fluffiness', 'FluffinessController');
Route::resource('category', 'CategoryController');
Route::resource('brand', 'BrandController');
Route::resource('colour', 'ColourController');
Route::resource('size', 'SizeController');
Route::resource('item', 'ItemController');
Route::resource('photo', 'PhotoController');



Route::get('/admin', function () {
    return view('admin.index');
});
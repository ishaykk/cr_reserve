<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoomController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('map', function () {
    return view('map');
});
// Route::get('/rooms', 'RoomController@index');
// Route::get('/rooms/create', 'RoomController@create');
// Route::post('/rooms', 'RoomController@store');
// Route::get('/rooms/{room}/edit', 'RoomController@edit')->name('rooms.edit');
// Route::patch('/rooms/{room}', 'RoomController@update')->name('rooms.update');
// Route::delete('/rooms/{room}', 'RoomController@destroy')->name('rooms.destroy');
Route::get('/orders/search', 'OrderController@search')->name('orders.search');
Route::resource('rooms', 'RoomController');
Route::resource('orders', 'OrderController');



// Route::get('/test', function () {
//     $arr = [['fname' => 'Nadav', 'lname' => 'Rosen', 'email' => 'nadav@test.com'],
//     return view('test', array(['fname' => 'Nadav', 'lname' => 'Rosen', 'email' => 'nadav@test.com']
//     ));
// });


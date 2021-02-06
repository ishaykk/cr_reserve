<?php

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

Route::get('/user/{id}', 'UserController@show')->name('user.show');
Route::get('/user/edit', 'UserController@edit')->name('user.edit');
Route::post('/user/edit', 'UserController@update')->name('user.update');

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
    Route::resource('/users','UsersController', ['except' => ['show', 'create','store',]]);
});
Route::get('/', 'HomeController@index')->name('home');
Route::get('/reset', 'HomeController@reset')->name('reset');

Route::get('map', function () {
    return view('map');
});
Route::get('/orders', 'OrderController@index');
Route::get('/orders/search', 'OrderController@search');
Route::post('/orders/create', 'OrderController@create');
Route::post('/orders', 'OrderController@store');
Route::get('/orders/{order}/edit', 'OrderController@edit')->name('orders.edit');

// Route::get('/rooms/{room}/edit', 'RoomController@edit')->name('rooms.edit');
// Route::patch('/rooms/{room}', 'RoomController@update')->name('rooms.update');
Route::delete('/orders/{order}', 'OrderController@destroy')->name('orders.destroy');
Route::resource('rooms', 'RoomController');
//Route::resource('orders', 'OrderController');




// Route::get('/test', function () {
//     $arr = [['fname' => 'Nadav', 'lname' => 'Rosen', 'email' => 'nadav@test.com'],
//     return view('test', array(['fname' => 'Nadav', 'lname' => 'Rosen', 'email' => 'nadav@test.com']
//     ));
// });


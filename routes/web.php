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

// Route::get('/users/{id}', 'UserController@show')->name('users.show');
// Route::get('/users/edit', 'UserController@edit')->name('users.edit');
// Route::post('/users/edit', 'UserController@update')->name('users.update');
Route::resource('/users', 'UserController');

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
    Route::resource('/users','UsersController', ['except' => ['show', 'create','store',]]);
});
Route::resource('/rooms', 'RoomController');
Route::get('floors/map', 'FloorController@showMap')->name('floors.map');
Route::resource('/floors', 'FloorController');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/reset', 'HomeController@reset')->name('reset');

// Route::get('map', function () {
    //     return view('map');
    // });
    
    
    Route::post('floordrawings/getDrawing/', 'FloorDrawingController@getDrawing');
Route::resource('/floordrawings', 'FloorDrawingController'/*, ['except' => ['show, store']]*/);
Route::get('/orders', 'OrderController@index')->name('orders.index');
Route::get('/orders/search', 'OrderController@search')->name('orders.search');
Route::post('/orders/create', 'OrderController@create')->name('orders.create');
Route::post('/orders', 'OrderController@store');
Route::get('/orders/{order}/edit', 'OrderController@edit')->name('orders.edit');
Route::delete('/orders/{order}', 'OrderController@destroy')->name('orders.destroy');
Route::get('orders/all', 'OrderController@getAllOrders')->name('orders.all');


// Route::get('/rooms/{room}/edit', 'RoomController@edit')->name('rooms.edit');
// Route::patch('/rooms/{room}', 'RoomController@update')->name('rooms.update');
//Route::resource('orders', 'OrderController');




// Route::get('/test', function () {
//     $arr = [['fname' => 'Nadav', 'lname' => 'Rosen', 'email' => 'nadav@test.com'],
//     return view('test', array(['fname' => 'Nadav', 'lname' => 'Rosen', 'email' => 'nadav@test.com']
//     ));
// });


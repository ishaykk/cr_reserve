<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Room;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('rooms/{room_id}', function($room_id) {
    return Room::findOrFail($room_id);
});

Route::get('rooms/', function() {
    return Room::where('occupied', 1)->pluck('room_id');
});

Route::get('roomState/{room_id}/{status}', function($room_id, $status) {
    $query = false;
    if($status >= 0 && $status <= 1)
        $query = Room::findOrFail($room_id)->update(['occupied' => $status]);
    return ($query) ? "Record Changed" : "Record wasn't changed";
});
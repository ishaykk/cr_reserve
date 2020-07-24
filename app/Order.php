<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $guarded = [];
    protected $dates = ['date', 'start_time', 'end_time'];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function room() 
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}

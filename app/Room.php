<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $primaryKey = 'room_id';
    protected $guarded = [];

    public function orders() 
    {
        return $this->hasMany(Order::class, 'order_id');
    }

    public function user() 
    {
        return $this->belongsTo(Floor::class);
    }

    public function floor() 
    {
        return $this->belongsTo(Floor::class);
    }
}

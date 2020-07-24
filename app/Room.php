<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $primaryKey = 'room_id';
    protected $guarded = [];

    public function orders() 
    {
        $this->hasMany(Order::class);
    }
}

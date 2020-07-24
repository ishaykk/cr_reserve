<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $guarded = [];

    public function user() 
    {
        $this->belongsTo(User::class);
    }

    public function room() 
    {
        $this->hasOne(Room::class);
    }
}

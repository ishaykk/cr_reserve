<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FloorDrawing extends Model
{
    protected $guarded = [];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function floor() 
    {
        return $this->belongsTo(Floor::class);
    }
}

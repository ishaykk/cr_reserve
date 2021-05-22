<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = ['floor_id', 'floordrawing_id'];

    public function drawing() 
    {
        return $this->belongsTo(FloorDrawing::class, 'floordrawing_id');
    }

    public function rooms() 
    {
        return $this->hasMany(Room::class);
    }
}

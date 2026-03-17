<?php

namespace App\Models;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Model;


class Place extends Model
{

     protected $fillable = [
    'user_id',
   'name',
    'description',
    'location',
    'type',
        'image_path'
];
    public function owner()
{
    return $this->belongsTo(User::class,'user_id');
}



public function rooms()
{
    return $this->hasMany(Room::class);
}

}

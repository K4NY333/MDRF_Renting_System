<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'start_date',
    'end_date',
    'monthly_rent',
    'contact_number',
    'activation_code', 
    'status',
    'room_id',
    'image_path',
    'pdf_path'
];

public function room()
{
    return $this->belongsTo(Room::class);
}
}

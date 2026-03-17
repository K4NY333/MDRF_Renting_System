<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandownerApplication extends Model
{
      protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'contact_number',
    'activation_code', 
    'status',
    'image_path',
    'pdf_path'
];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomTenant extends Model
{  
    
    
    
    protected $fillable = [
        'room_id',
        'tenant_id',
        'start_date',
        'end_date',
        'monthly_rent',
        'status',
    ];

    // Relationships
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }




}

<?php

namespace App\Models;
use App\Models\Place;
use App\Models\RoomImage;
use App\Models\RoomTenant;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
protected $fillable = [
    'place_id', 'name', 'type', 'status', 'capacity', 'price',
    'kitchen_equipment', 'furniture_equipment', 'cctv',
    'laundry_area', 'allowed_pets', 'has_wifi'
];
    
    public function place()
{
    return $this->belongsTo(Place::class, 'place_id');
}

public function images()
{
    return $this->hasMany(RoomImage::class);
}

public function roomImages() {
    return $this->hasMany(RoomImage::class);
}
  public function roomTenants()
    {
        return $this->hasMany(RoomTenant::class);
    }

    public function maintenanceRequests()
{
    return $this->hasMany(MaintenanceRequest::class);
}


}

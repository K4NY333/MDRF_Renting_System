<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    //

     protected $fillable = [

        'room_id',
        'tenant_id',
        'description',
        'status'  ,
        'service_type', // New: Service type of the request 
        'staff_id'             
     ];
    

    // If user is tenant, maintenance requests made by tenant
public function maintenanceRequests()
{
    return $this->hasMany(MaintenanceRequest::class, 'tenant_id');
}

// If user is owner, maintenance requests for all rooms owned by the user
public function ownedPlaces()
{
    return $this->hasMany(Place::class, 'user_id');
}

public function maintenanceRequestsForOwnedRooms()
{
    return MaintenanceRequest::whereHas('room.place', function ($query) {
        $query->where('user_id', $this->id);
    });
}

 public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id')->where('role', 'tenant');
    }

    public function roomTenant()
    {
        return $this->belongsTo(RoomTenant::class);
    }


      public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function staff()
{
    return $this->belongsTo(Staff::class);
}

}

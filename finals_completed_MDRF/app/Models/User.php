<?php

namespace App\Models;
use App\Models\Place;
use App\Models\MaintenanceRequest;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
  protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'contact_number',
    'image_path'
];
  
  public function places()
  {
      return $this->hasMany(Place::class);
  }

  public function roomsApplied()
{
    return $this->belongsToMany(Room::class, 'room_tenants', 'tenant_id', 'room_id');
}

public function rooms() {
    return $this->hasMany(Room::class, 'owner_id');
}


public function application()
{
    return $this->hasOne(\App\Models\LandownerApplication::class, 'email', 'email');
}

public function roomTenant()
{
    return $this->hasOne(\App\Models\RoomTenant::class, 'tenant_id', 'id');
}

   
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

}

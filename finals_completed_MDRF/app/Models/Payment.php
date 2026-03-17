<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    // Fillable fields to allow mass assignment
    protected $fillable = [
        'room_tenant_id',
        'tenant_id',
        'amount',
        'due_date',
        'paid_date',
        'status',
        'method',
        'qr_proof',
        'tenant_name',
        'confirmed_by',
    ];

    // Casts for date fields
    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    // Relationships
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id')->where('role', 'tenant');
    }

    public function roomTenant()
    {
        return $this->belongsTo(RoomTenant::class);
    }

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    // Optional: Scope to get only paid payments
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // Optional: Scope to get only unpaid payments
    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }
}

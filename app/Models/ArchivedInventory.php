<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'name',
        'type',
        'quantity',
        'expiration_date',
        'status',    // expired, used, damaged, other
        'notes',
        'staff_id',
        'patient_id',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}

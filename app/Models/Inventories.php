<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventories extends Model
{
    use HasFactory;

    protected $table = 'inventories'; // optional, Laravel infers this automatically

    protected $fillable = [
        'name',
        'category',
        'type',
        'quantity',
        'condition',
        'expiration_date',
        'admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'inventory_id');
    }
}

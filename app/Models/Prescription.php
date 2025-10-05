<?php
namespace App\Models;

use App\Models\Inventories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_session_id',
        'inventory_id',
        'dosage',
        'frequency',
        'duration',
        'quantity',
    ];

    public function clinicSession()
    {
        return $this->belongsTo(ClinicSession::class);
    }

    public function inventories()
    {
        return $this->belongsTo(Inventories::class);
    }

    // // 🔥 Automatically deduct from inventory when prescription is created
    // protected static function booted()
    // {
    //     static::created(function ($prescription) {
    //         $inventory = $prescription->inventory;

    //         if ($inventory && $inventory->quantity >= $prescription->quantity) {
    //             $inventory->decrement('quantity', $prescription->quantity);
    //         } else {
    //             throw new \Exception("Not enough stock in inventory for {$inventory->name}");
    //         }
    //     });

    //     // ✅ If prescription is deleted, restore stock
    //     static::deleted(function ($prescription) {
    //         $inventory = $prescription->inventory;
    //         if ($inventory) {
    //             $inventory->increment('quantity', $prescription->quantity);
    //         }
    //     });

    //     // ✅ If prescription quantity is updated, adjust stock difference
    //     static::updated(function ($prescription) {
    //         if ($prescription->isDirty('quantity')) {
    //             $oldQuantity = $prescription->getOriginal('quantity');
    //             $newQuantity = $prescription->quantity;
    //             $difference = $newQuantity - $oldQuantity;

    //             $inventory = $prescription->inventory;

    //             if ($inventory) {
    //                 if ($difference > 0 && $inventory->quantity >= $difference) {
    //                     // Decrease more
    //                     $inventory->decrement('quantity', $difference);
    //                 } elseif ($difference < 0) {
    //                     // Restore if reduced quantity
    //                     $inventory->increment('quantity', abs($difference));
    //                 } elseif ($difference > 0 && $inventory->quantity < $difference) {
    //                     throw new \Exception("Not enough stock in inventory to increase prescription for {$inventory->name}");
    //                 }
    //             }
    //         }
    //     });
    // }
       public $timestamps = false;
}

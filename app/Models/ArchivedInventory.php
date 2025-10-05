<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'quantity',
        'condition',
        'expiration_date',
        'notes',
    ];
    public function handle()
{
    $items = Inventory::where('expiration_date', '<', now())
                      ->orWhere('condition', 'Used')
                      ->get();

    foreach ($items as $item) {
        ArchivedInventory::create([
            'name' => $item->name,
            'type' => $item->type,
            'quantity' => $item->quantity,
            'condition' => $item->condition ?? 'Expired',
            'expiration_date' => $item->expiration_date,
            'notes' => 'Automatically archived via scheduler',
        ]);

        $item->delete();
    }

    $this->info('Inventory archived successfully.');
}

}

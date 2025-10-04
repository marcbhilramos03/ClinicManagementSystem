<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventory;
use App\Models\ExpiredInventory;
use Carbon\Carbon;

class MoveExpiredInventory extends Command
{
    protected $signature = 'inventory:move-expired';
    protected $description = 'Move expired medicines to expired_inventories table';

    public function handle()
    {
        $today = Carbon::today();

        $expiredItems = Inventory::whereNotNull('expiration_date')
            ->where('expiration_date', '<', $today)
            ->get();

        foreach ($expiredItems as $item) {
            ExpiredInventory::create($item->toArray());
            $item->delete();
        }

        $this->info(count($expiredItems).' expired items moved.');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $adminId = 1; // Replace with an actual admin user ID

        $conditions = ['new', 'good', 'fair', 'poor'];
        $medicineTypes = ['tablet', 'capsule', 'syrup', 'injection'];
        $equipmentTypes = ['diagnostic', 'surgical', 'disposable', 'therapeutic'];

        $inventories = [];

        // Generate 20 medicines
        for ($i = 0; $i < 20; $i++) {
            $inventories[] = [
                'name' => ucfirst($faker->word()) . ' ' . $faker->randomElement($medicineTypes),
                'category' => 'medicine',
                'type' => $faker->randomElement($medicineTypes),
                'quantity' => $faker->numberBetween(10, 500),
                'condition' => $faker->randomElement($conditions),
                'expiration_date' => Carbon::now()->addMonths($faker->numberBetween(6, 36))->toDateString(),
                'admin_id' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Generate 10 equipment
        for ($i = 0; $i < 10; $i++) {
            $type = $faker->randomElement($equipmentTypes);
            $inventories[] = [
                'name' => ucfirst($faker->word()) . ' ' . $type,
                'category' => 'equipment',
                'type' => $type,
                'quantity' => $faker->numberBetween(5, 100),
                'condition' => $faker->randomElement($conditions),
                'expiration_date' => null, // equipment does not expire
                'admin_id' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('inventories')->insert($inventories);
    }
}

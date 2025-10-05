<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $adminId = 1; // Change this to match your admin user ID

        $conditions = ['New', 'Good', 'Fair', 'Poor'];

        // Realistic medicine examples
        $medicines = [
            ['name' => 'Paracetamol Tablet', 'type' => 'tablet'],
            ['name' => 'Amoxicillin Capsule', 'type' => 'capsule'],
            ['name' => 'Cough Syrup', 'type' => 'syrup'],
            ['name' => 'Vitamin C Tablet', 'type' => 'tablet'],
            ['name' => 'Ibuprofen Capsule', 'type' => 'capsule'],
            ['name' => 'Antibiotic Syrup', 'type' => 'syrup'],
            ['name' => 'Insulin Injection', 'type' => 'injection'],
            ['name' => 'Antihistamine Tablet', 'type' => 'tablet'],
            ['name' => 'Pain Relief Capsule', 'type' => 'capsule'],
            ['name' => 'Cough Suppressant Syrup', 'type' => 'syrup'],
            ['name' => 'Multivitamin Tablet', 'type' => 'tablet'],
            ['name' => 'Antacid Syrup', 'type' => 'syrup'],
            ['name' => 'Iron Supplement Capsule', 'type' => 'capsule'],
            ['name' => 'Paracetamol Syrup', 'type' => 'syrup'],
            ['name' => 'Hydrocortisone Cream', 'type' => 'cream'],
            ['name' => 'Antibiotic Ointment', 'type' => 'ointment'],
            ['name' => 'Oral Rehydration Solution', 'type' => 'solution'],
            ['name' => 'Antiseptic Solution', 'type' => 'solution'],
            ['name' => 'Allergy Relief Tablet', 'type' => 'tablet'],
            ['name' => 'Painkiller Injection', 'type' => 'injection'],
        ];

        // Realistic equipment examples
        $equipments = [
            ['name' => 'Stethoscope', 'type' => 'diagnostic'],
            ['name' => 'Thermometer', 'type' => 'diagnostic'],
            ['name' => 'Blood Pressure Monitor', 'type' => 'diagnostic'],
            ['name' => 'Surgical Scissors', 'type' => 'surgical'],
            ['name' => 'Disposable Gloves', 'type' => 'disposable'],
            ['name' => 'Face Mask', 'type' => 'disposable'],
            ['name' => 'Syringe', 'type' => 'disposable'],
            ['name' => 'First Aid Kit', 'type' => 'therapeutic'],
            ['name' => 'Wheelchair', 'type' => 'therapeutic'],
            ['name' => 'Crutches', 'type' => 'therapeutic'],
        ];

        $inventoryItems = [];

        // Add medicines
        foreach ($medicines as $item) {
            $inventoryItems[] = [
                'name' => $item['name'],
                'category' => 'medicine',
                'type' => $item['type'],
                'quantity' => rand(10, 500),
                'condition' => $conditions[array_rand($conditions)],
                'expiration_date' => Carbon::now()->addMonths(rand(6, 36))->toDateString(),
                'admin_id' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Add equipment
        foreach ($equipments as $item) {
            $inventoryItems[] = [
                'name' => $item['name'],
                'category' => 'equipment',
                'type' => $item['type'],
                'quantity' => rand(5, 100),
                'condition' => $conditions[array_rand($conditions)],
                'expiration_date' => null, // equipment doesn’t expire
                'admin_id' => $adminId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('inventories')->insert($inventoryItems);
    }
}

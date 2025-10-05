<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckupTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: clear the table before seeding
        // DB::table('checkup_types')->truncate();

        $checkupTypes = [
            [
                'name' => 'General Checkup',
                'description' => 'A routine medical examination to assess overall health and detect potential issues early.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emergency Checkup',
                'description' => 'Immediate medical attention for sudden illnesses, injuries, or urgent conditions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Walk-In Checkup',
                'description' => 'A non-scheduled visit for patients without prior appointments who need general consultation.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dental Checkup',
                'description' => 'An oral health assessment focusing on the teeth, gums, and mouth to prevent or treat dental problems.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('checkup_types')->insert($checkupTypes);
    }
}

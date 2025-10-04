<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',               // predefine username
            'password' => Hash::make('password'), // predefine password
            'role'     => 'admin', 
            'profile_complete'     => '1',         
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

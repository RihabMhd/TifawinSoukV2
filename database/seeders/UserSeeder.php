<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@tifawinsouk.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '+212 6 12 34 56 78',
            'image' => null,
            'role_id' => 1, // admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@tifawinsouk.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '+212 6 98 76 54 32',
            'image' => null,
            'role_id' => 2, // vendor
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Customer User',
            'email' => 'customer@tifawinsouk.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '+212 6 11 22 33 44',
            'image' => null,
            'role_id' => 3, // customer
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        User::factory(20)->create();
    }
}

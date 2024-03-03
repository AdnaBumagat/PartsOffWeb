<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProvinceSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //* create admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'role' => 2,
        ]);

        //* create customer
        \App\Models\User::factory()->create([
            'name' => 'customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('customer1'),
            'role' => 1,
        ]);

        //* Call other seeders
        $this->call([
            ProvinceSeeder::class,
            CategorySeeder::class
        ]);

    }
}

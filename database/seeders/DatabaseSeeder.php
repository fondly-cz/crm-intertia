<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Fondly Admin',
            'email' => 'spoluprace@fondly.cz',
            'password' => \Illuminate\Support\Facades\Hash::make('admin'),
            'role' => \App\Enums\UserRole::ADMIN,
        ]);

        $this->call([
            CompanySeeder::class,
            ServiceSeeder::class,
            CalculationSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use App\Models\Vehicles;
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
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => 'admin1234$'
        ]);

        // Client::factory(30)->create();
        // Vehicles::factory(30)->create();

    }
}

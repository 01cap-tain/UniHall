<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Tobi',
            'last_name' => 'Gideon',
            'email' => 'test@example.com',
            'matric_number' => 'sci22csc777',
            'password' => 'secret22',
        ]);

        // Venue::factory(10)->create();

    }
}

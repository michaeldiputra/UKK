<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $email = 'michael@owner.com';
        if (!User::where('email', $email)->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make('password'),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EncoderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the user already exists to avoid duplicates
        if (!User::where('email', 'encoder@gmail.com')->exists()) {
            User::create([
                'name' => 'Encoder User',
                'email' => 'encoder@gmail.com',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ENCODER,
            ]);
            $this->command->info('Encoder user created successfully.');
        } else {
            $this->command->info('Encoder user already exists.');
        }
    }
}

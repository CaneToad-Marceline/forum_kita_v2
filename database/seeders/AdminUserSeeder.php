<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // 👈 import the User model
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // find or create this email
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'), // change later for security
                'role' => 'admin', // make sure users table has 'role' column
            ]
        );
    }
}

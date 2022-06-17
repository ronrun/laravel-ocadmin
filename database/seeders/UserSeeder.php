<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.org',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'name' => 'Administrator',
            'status' => 1,
            ]);

        User::factory()
        ->count(50)
        ->create();
    }
}

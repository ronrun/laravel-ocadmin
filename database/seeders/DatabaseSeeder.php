<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::truncate();
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.org',
            'password' => bcrypt('123456'),
            'name' => 'Administrator',
            'is_active' => 1,
            ]);
    }
}

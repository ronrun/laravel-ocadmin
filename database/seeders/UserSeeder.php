<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\User;

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
            'code' => '1090001',
            'username' => 'admin',
            'email' => 'admin@example.org',
            'password' => bcrypt('123456'),
            'name' => 'Administrator',
            'is_active' => 1,
            ]);
    }
}

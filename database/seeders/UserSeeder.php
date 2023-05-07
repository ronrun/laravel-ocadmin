<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User\User;
use App\Models\User\Usermeta;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User
        User::truncate();
        User::create([
            'id' => '1',
            'username' => 'admin',
            'user_nicename' => 'admin',
            'display_name' => 'Administrator',
            'email' => 'admin@example.org',
            'password' => bcrypt('123456'),
            'is_active' => 1,
            'is_admin' => 1,
            ]);
            
        User::factory()->count(200)->create(); 

        // Usermeta
        Usermeta::truncate();
        
        Usermeta::create([
            'user_id' => '1',
            'meta_key' => 'first_name',
            'meta_value' => 'John',
        ]);
        
        Usermeta::create([
            'user_id' => '1',
            'meta_key' => 'last_name',
            'meta_value' => 'Doe',
        ]);
        
        Usermeta::create([
            'user_id' => '1',
            'meta_key' => 'admin_last_active',
            'meta_value' => now(),
        ]);
    }
}

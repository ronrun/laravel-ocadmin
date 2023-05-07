<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();

        Setting::create([
            'group' => 'default',
            'key' => 'timezone',
            'value' => 'Asia/Taipei',
            'is_autoload' => 1,
        ]);
        
        Setting::create([
            'group' => 'default',
            'key' => 'default_login_attempts',
            'value' => 5,
            'is_autoload' => 1,
        ]);
            
        Setting::create([
            'group' => 'default',
            'key' => 'currency',
            'value' => 'TWD',
            'is_autoload' => 1,
        ]);
            
        Setting::create([
            'group' => 'default',
            'key' => 'language',
            'value' => 'zh-Hant',
            'is_autoload' => 1,
        ]);

        Setting::create([
            'group' => 'default',
            'key' => 'admin_pagination',
            'value' => 10,
            'is_autoload' => 1,
        ]);
        
        Setting::create([
            'group' => 'default',
            'key' => 'admin_language',
            'value' => 'zh-Hant',
            'is_autoload' => 1,
        ]);      
            
    }
}

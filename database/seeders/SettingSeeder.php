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
            'key' => 'default_login_attempts',
            'value' => 5,
            ]);
        Setting::create([
            'group' => 'default',
            'key' => 'admin_pagination',
            'value' => 10,
            ]);
        
        Setting::create([
            'group' => 'default',
            'key' => 'admin_language',
            'value' => 'zh-hant',
            ]);

        Setting::create([
            'group' => 'default',
            'key' => 'timezone',
            'value' => 'Asia/Taipei',
            ]);
            
        Setting::create([
            'group' => 'default',
            'key' => 'currency',
            'value' => 'TWD',
        ]);

            
        Setting::create([
            'group' => 'default',
            'key' => 'language',
            'value' => 'zh-hant',
        ]);            
            
    }
}

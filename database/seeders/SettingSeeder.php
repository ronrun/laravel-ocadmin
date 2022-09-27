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
            'group' => 'config',
            'key' => 'config_pagination',
            'value' => 10,
            ]);
        
        Setting::create([
            'group' => 'config',
            'key' => 'config_pagination_admin',
            'value' => 10,
            ]);
        
        Setting::create([
            'group' => 'config',
            'key' => 'config_mail_smtp_hostname',
            'value' => '',
            ]);

        Setting::create([
            'group' => 'config',
            'key' => 'config_mail_smtp_username',
            'value' => '',
            ]);

        Setting::create([
            'group' => 'config',
            'key' => 'config_mail_smtp_password',
            'value' => '',
            ]);

        Setting::create([
            'group' => 'config',
            'key' => 'config_mail_smtp_port',
            'value' => '25',
            ]);

        Setting::create([
            'group' => 'config',
            'key' => 'config_mail_smtp_timeout',
            'value' => 60,
            ]);

        Setting::create([
            'group' => 'config',
            'key' => 'config_login_attempts',
            'value' => 5,
            ]);            
            
        Setting::create([
            'group' => 'config',
            'key' => 'config_tin', //統編或稅號 Tax Identification Number
            'value' => '',
            ]);
        
        Setting::create([
            'group' => 'config',
            'key' => 'config_address',
            'value' => '',
            ]);
        
        Setting::create([
            'group' => 'config',
            'key' => 'config_telephone',
            'value' => '02-2278-1531',
            ]);
        
        Setting::create([
            'group' => 'config',
            'key' => 'config_fax',
            'value' => '02-2995-6656',
            ]);
            
        Setting::create([
            'group' => 'config',
            'key' => 'config_image_thumb_width',
            'value' => '500',
            ]);
            
        Setting::create([
            'group' => 'config',
            'key' => 'config_image_thumb_height',
            'value' => '500',
            ]);
            
        Setting::create([
            'group' => 'config',
            'key' => 'config_image_popup_width',
            'value' => '800',
            ]);
            
        Setting::create([
            'group' => 'config',
            'key' => 'config_image_popup_height',
            'value' => '800',
            ]);
            
        Setting::create([
            'group' => 'config',
            'key' => 'config_image_product_width',
            'value' => '250',
            ]);
            
        Setting::create([
            'group' => 'config',
            'key' => 'config_image_product_height',
            'value' => '250',
            ]);

            
        Setting::create([
            'group' => 'config',
            'key' => 'config_image_related_width',
            'value' => '250',
            ]);
            
        Setting::create([
            'group' => 'config',
            'key' => 'config_image_related_height',
            'value' => '250',
            ]);
            
        Setting::create([
            'group' => 'config',
            'key' => 'config_image_compare_width',
            'value' => '90',
            ]);

        Setting::create([
            'group' => 'config',
            'key' => 'config_image_compare_height',
            'value' => '90',
            ]);
            
        Setting::create([
            'group' => 'config',
            'key' => 'config_logo',
            'value' => '',
            ]);

        Setting::create([
            'group' => 'config',
            'key' => 'config_meta_title',
            'value' => '',
            ]);
        
        Setting::create([
            'group' => 'config',
            'key' => 'config_meta_description',
            'value' => '',
            ]);
        
        Setting::create([
            'group' => 'config',
            'key' => 'config_meta_keyword',
            'value' => '',
            ]);
        
        Setting::create([
            'group' => 'config',
            'key' => 'config_stock_display', 
            'value' => '0',
            ]);
            
    }
}

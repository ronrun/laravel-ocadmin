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
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_pagination',
            'value' => 10,
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_pagination_admin',
            'value' => 10,
            ]);

        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_login_attempts',
            'value' => 5,
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_name',
            'value' => 'My Store',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_owner',
            'value' => 'Adam Smith',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_tin', //Tax Identification Number
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_address',
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_telephone',
            'value' => '02-1234-5678',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_fax',
            'value' => '02-1234-5678',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_image_thumb_width',
            'value' => '500',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_image_thumb_height',
            'value' => '500',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_image_popup_width',
            'value' => '800',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_image_popup_height',
            'value' => '800',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_image_product_width',
            'value' => '250',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_image_product_height',
            'value' => '250',
            ]);

            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_image_related_width',
            'value' => '250',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_image_related_height',
            'value' => '250',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_image_compare_width',
            'value' => '90',
            ]);

        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_image_compare_height',
            'value' => '90',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_logo',
            'value' => '',
            ]);

        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_meta_title',
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_meta_description',
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_meta_keyword',
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_stock_display', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_mail_engine', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_mail_parameter', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_mail_smtp_hostname', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_mail_smtp_username', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_mail_smtp_password', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_mail_smtp_port', 
            'value' => '25',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_mail_smtp_timeout', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_maintenance', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_session_expire', 
            'value' => '86400',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_robots', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_security', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_shared', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_encryption', 
            'value' => '',
            ]);
            
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_file_max_size', 
            'value' => '',
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_file_ext_allowed', 
            'value' => "zip\r\ntxt\r\npng\r\njpe\r\njpeg\r\nwebp\r\njpg\r\ngif\r\nbmp\r\nico\r\ntiff\r\ntif\r\nsvg\r\nsvgz\r\nzip\r\nrar\r\nmsi\r\ncab\r\nmp3\r\nmp4\r\nqt\r\nmov\r\npdf\r\npsd\r\nai\r\neps\r\nps\r\ndoc",
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_file_mime_allowed', 
            'value' => "text/plain\r\nimage/png\r\nimage/webp\r\nimage/jpeg\r\nimage/gif\r\nimage/bmp\r\nimage/tiff\r\nimage/svg+xml\r\napplication/zip\r\napplication/x-zip\r\napplication/x-zip-compressed\r\napplication/rar\r\napplication/x-rar\r\napplication/x-rar-compressed\r\napplication/octet-stream\r\naudio/mpeg\r\nvideo/mp4\r\nvideo/quicktime\r\napplication/pdf",
            ]);
        
        Setting::create([
            'organization_id' => '0',
            'group' => 'config',
            'key' => 'config_mobile_required', 
            'value' => "0",
            ]);

            
            
            
    }
}

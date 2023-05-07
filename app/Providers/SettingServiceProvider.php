<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting\Setting;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function boot()
    {
        if (Schema::hasTable('settings')) {
            $settings = Setting::where('is_autoload', 1)->get();
            foreach ($settings as $setting) {
                $key = 'setting.' . $setting->key;
                $value = $setting->is_json ? json_decode($setting->value) : $setting->value;
                Config::set($key, $value);
            }
        }
    }
}
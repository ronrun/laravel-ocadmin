<?php

/**
 * This class is used to replace laraval's original localization, and is used in all controllers.
 * Created by Ron
 * Modified: 2023-10-21
 */

namespace App\Libraries;

use Illuminate\Support\Facades\Lang;

class TranslationLibrary
{
    public $fallback_locale;
    public $locale;
    public $driver;
    public $data;
    private $group;

    public function getTranslations($group)
    {        
        $this->group = $group;
        $this->driver = config('app.translatoin_driver');

        $fallback_locale = config('app.fallback_locale');
        $locale = app()->getLocale();

        if($this->driver == 'file') {
            $translations = $this->getFileTranslations($locale);
        }

        return (object) $translations;
    }

    public function getFileTranslations($locale)
    {
        $this->data = new TranslationData();

        $current_locale = app()->getLocale();
        $fallback_locale = config('app.fallback_locale');
        
        foreach ($this->group as $folder_path) {
            $current_translations = Lang::get($folder_path, [], $current_locale);
            $fallback_translations = Lang::get($folder_path, [], $fallback_locale);

            if(is_array($current_translations)){
                foreach ($current_translations as $key => $value) {
                    $this->data->$key = $value;
                }
            }
            
            // If the fallback language exists, but the current locale does not.
            if(is_array($fallback_translations)){
                $current_keys = array_keys($current_translations);
                foreach ($fallback_translations as $key => $value) {
                    if(!in_array($key, $current_keys)){
                        $this->data->$key = $value;
                    }
                }
            }
        }
        
        return $this->data;
    }
}

class TranslationData
{
    public function __get($key)
    {
        if(isset($this->$key)){
            return $this->$key;
        }
        return $key;     
    }

    public function trans($key)
    {
        return $this->__get($key);
    }
}
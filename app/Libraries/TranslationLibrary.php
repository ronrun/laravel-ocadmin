<?php

/**
 * This class is used to replace laraval's original localization.
 * Created by Ron, 2024
 */

namespace App\Libraries;

use Illuminate\Support\Facades\Lang;

class TranslationLibrary
{
    public $fallback_locale;
    public $fallback_translations;
    public $locale;
    public $paths;
    public $driver;

    // getTransBypaths
    public function getTranslations($paths)
    {        
        $this->paths = $paths;
        $this->driver = config('app.translatoin_driver');

        $fallback_locale = config('app.fallback_locale');
        
        if($this->driver == 'file') {
            $translations = $this->getFileTranslations();

            if($this->fallback_locale !== $this->locale){
                $fallback_translations = (array) $this->getFileTranslations($fallback_locale);
                $translations = array_replace_recursive($fallback_translations, $translations);
            }
        }

        return $translations;
    }

    public function getFileTranslations()
    {
        $data = [];

        // read translation files
        foreach ($this->paths as $path) {
            $arr = Lang::get($path);
            if(is_array($arr)){
                foreach (Lang::get($path) as $key => $value) {
                    $data[$key] = $value;
                }
            }
        }

        $data = new TranslationData($data);
        
        return $data;
    }
}

class TranslationData
{
    public $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __get($key)
    {
        if(isset($this->data[$key])){
            return $this->data[$key];
        }

        return $key;     
    }

    public function trans($key)
    {
        return $this->__get($key);
    }

    public function set($setVariable, $setValue)
    {
        $this->data[$setVariable] = $setValue;
    }
}
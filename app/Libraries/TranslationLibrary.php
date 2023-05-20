<?php

/**
 * This class is used to replace laraval's original localization, and is used in all controllers.
 * Created by Ron, 2022
 */

namespace App\Libraries;

use Illuminate\Support\Facades\Lang;

class TranslationLibrary
{
    public $paths;
    public $driver;
    public $data;

    public function getTranslations($paths)
    {
        $this->data = new TranslationData();

        $this->driver = config('app.translatoin_driver');

        if($this->driver == 'file') {
            $translations = $this->getFileTranslations($paths);
        }
        // else if($this->driver == 'database') {
        //     $translations = $this->getDatabaseTranslations($paths);
        // }

        return $translations;
    }

    public function getFileTranslations($paths)
    {
        foreach ($paths as $path) {
            $translations = Lang::get($path);
            if(is_array($translations)){
                foreach ($translations as $key => $value) {
                    $this->data->$key = $value;
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
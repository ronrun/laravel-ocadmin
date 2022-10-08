<?php

namespace App\Libraries;

use App\Models\Localization\Translation;
use Lang;

class TranslationLibrary
{
    public $fallback_locale;
    public $locale;
    public $group;
    public $data;

    public function __construct()
    {
        $this->driver = config('app.translatoin_driver');
    }

    // getTransByGroups
    public function getTranslations($groups)
    {
        $fallback_locale = config('app.fallback_locale');
        $locale = \App::getLocale();

        if($this->driver == 'file') {
            $translations = $this->getFileTranslations($groups, $locale);
            if($this->fallback_locale !== $this->locale){
                $fallback_translations = $this->getFileTranslations($groups, $fallback_locale);
                $translations = array_replace_recursive($fallback_translations, $translations);
            }
        }
        else if($this->driver == 'database') {
            $translations = $this->getDatabaseTranslations($groups, $locale);
            if($this->fallback_locale !== $this->locale){
                $fallback_translations = $this->getDatabaseTranslations($groups, $fallback_locale);
                
                $translations = array_replace_recursive($fallback_translations, $translations);
            }

        }
        return $this->data = (object)$translations;
    }

    public function getDatabaseTranslations($groups, $locale)
    {
        foreach ($groups as $group) {
            $query = Translation::query();

            $rows = $query->select('key','value')
                ->where('locale',$locale)
                ->where('group',$group)
                ->get()->pluck('value','key')->toArray();

            foreach ($rows as $key => $value) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public function getFileTranslations($groups, $locale)
    {
        if(!is_array($groups)){
            return false;
        }

        $lang = (object)[];

        foreach ($groups as $group) {
            $arr = Lang::get($group);
            if(is_array($arr)){
                foreach (Lang::get($group) as $key => $value) {
                    $lang->$key = $value;
                }
            }
        }
        
        return $lang;
    }
}



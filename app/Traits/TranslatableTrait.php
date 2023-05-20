<?php

namespace App\Traits;

trait TranslatableTrait
{
    public function translations($translationModelName = null)
    {
        if(empty($translationModelName)){
            $translationModelName = get_class($this) . 'Translation';
            $translactionModel = new $translationModelName();
        }

        return $this->hasMany($translactionModel::class);
    }

    public function translation($locale = null, $translationModelName = null)
    {
        if(empty($locale)){
            $locale = app()->getLocale();
        }

        if(empty($translationModelName)){
            $translationModelName = get_class($this) . 'Translation';
            $translactionModel = new $translationModelName();
        }

        return $this->hasOne($translactionModel::class)->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('locale', app()->getLocale());
        });
    }

    public function sortedTranslations()
    {
        $translations = (object) $this->translations->keyBy('locale')->toArray();
        
        foreach($translations as $locale => $translation){
            $translations->$locale = (object) $translation;
        }

        return $translations;
    }

    
    /**
     * @param  string|array|null  $locales  The locales to be deleted
     */
    public function deleteTranslations($locales = null): void
    {
        if ($locales === null) {
            $translations = $this->translations()->get();
        } else {
            $locales = (array) $locales;
            $translations = $this->translations()->whereIn($this->getLocaleKey(), $locales)->get();
        }

        $translations->each->delete();

        // we need to manually "reload" the collection built from the relationship
        // otherwise $this->translations()->get() would NOT be the same as $this->translations
        $this->load('translations');
    }
}
<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

trait ModelTrait
{
    public function getTableColumns()
    {
        return Schema::getColumnListing($this->getTable());
    }

    public function getModelNamespace()
    {
        $namespaceParts = explode('\\', __CLASS__);
        array_pop($namespaceParts); // 移除最後一個元素（即模型的類別名稱）
        return implode('\\', $namespaceParts);
    }

    public function getTranslationTable()
    {
        return $this->getTranslationModel()->getTable();
    }

    public function getTranslationModel()
    {
        if(!empty($this->translation_model_name)){
            $translation_model_name = $this->getModelNamespace() . '\\'.$this->translation_model_name;
        }else{
            $translation_model_name = get_class($this) . 'Translation';
        }

        return new $translation_model_name;
    }

    public function getMetaModel()
    {
        if(!empty($this->meta_model_name)){
            $meta_model_name = $this->meta_model_name;
        }else{
            $meta_model_name = get_class($this) . 'Meta';
        }

        return new $meta_model_name();
    }
    

    // Relation
    public function metas()
    {
        $meta_model_name = get_class($this) . 'Meta';
        return $this->hasMany($meta_model_name);
    }

    public function translation()
    {
        // Using SomeMeta 
        if (isset($this->translation_model_name) && substr($this->translation_model_name, -4) === 'Meta') {
            return $this->metas()->where('locale', app()->getLocale());
        }
        // Using SomeTranslation
        else{
    
            if(empty($translationModelName)){
                $translation_model_name = get_class($this) . 'Translation';
                $translation_model = new $translation_model_name();
            }
    
            return $this->hasOne($translation_model::class)->ofMany([
                'id' => 'max',
            ], function ($query) {
                $query->where('locale', app()->getLocale());
            });
        }
        
    }

    public function translations()
    {
        // Using SomeMeta 
        if (isset($this->translation_model_name) && substr($this->translation_model_name, -4) === 'Meta') {
            return $this->metas()->whereNotNull('locale')->where('locale', '<>', '');
        }
        // Using SomeTranslation
        else{
            $translation_model_name = get_class($this) . 'Translation';
            $translation_model = new $translation_model_name();
    
            return $this->hasMany($translation_model::class);
        }
    }

    public function sortedTranslations()
    {
        // Using SomeMeta 
        if (isset($this->translation_model_name) && substr($this->translation_model_name, -4) === 'Meta') {
            foreach($this->translations as $translation){
                $locale = $translation->locale;
                $key = $translation->meta_key;
                $arr[$locale][$key] = $translation->meta_value;
            }
    
            return $arr;
        }
        // Using SomeTranslation
        else{
            $translations = (object) $this->translations->keyBy('locale')->toArray();

            foreach($translations as $locale => $translation){
                $translations->$locale = (object) $translation;
            }
    
            return $translations;
        }
    }

    // public function deleteTranslations($locales = null): void
    // {
    //     if ($locales === null) {
    //         $translations = $this->translations()->get();
    //     } else {
    //         $locales = (array) $locales;
    //         $translations = $this->translations()->whereIn($this->getLocaleKey(), $locales)->get();
    //     }

    //     $translations->each->delete();

    //     // we need to manually "reload" the collection built from the relationship
    //     // otherwise $this->translations()->get() would NOT be the same as $this->translations
    //     $this->load('translations');
    // }

    // Attribute

    public function dateCreated(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }

    public function dateModified(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }
    
}
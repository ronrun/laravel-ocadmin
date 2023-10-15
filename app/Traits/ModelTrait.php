<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

trait ModelTrait
{
    // Relation
    public function metas()
    {
        $meta_model_name = get_class($this) . 'Meta';
        return $this->hasMany($meta_model_name);
    }

    public function translation()
    {
        return $this->metas()->where('locale', app()->getLocale());
    }

    public function translations()
    {
        return $this->metas()->whereNotNull('locale');
    }

    public function sortedTranslations()
    {
        foreach($this->translations as $translation){
            $locale = $translation->locale;
            $key = $translation->meta_key;
            $arr[$locale][$key] = $translation->meta_value;
        }

        return $arr;
    }


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
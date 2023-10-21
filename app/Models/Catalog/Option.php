<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;

class Option extends Model
{
    use ModelTrait;

    protected $table = 'terms';
    protected $guarded = [];
    protected $appends = ['name','slug',];
    public $translated_attributes = ['name', 'slug',];

    public function option_values()
    {
        return $this->hasMany(OptionValue::class, 'parent_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
 
        static::addGlobalScope(function ($query) {
            $query->where('taxonomy_code', 'product_option');
        });
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->name ?? '',
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->description ?? '',
        );
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->slug ?? '',
        );
    }

}

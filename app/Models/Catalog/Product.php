<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;
use App\Traits\TranslatableTrait;

class Product extends Model
{
    use HasFactory;
    use TranslatableTrait;
    use ModelTrait;

    protected $guarded = [];
    protected $appends = ['name'];
    public $translated_attributes = ['name','description', 'meta_title', 'meta_description', 'meta_keyword',];
    public $translation_foreign_key = 'product_id';

    // Attribute
    
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value),
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->name ?? '',
        );
    }


    protected function shortName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->short_name ?? '',
        );
    }
}

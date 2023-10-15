<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;
use App\Models\Catalog\ProductMeta;

class Product extends Model
{
    use HasFactory;
    use ModelTrait;

    public $translation_attributes = ['name','description', 'meta_title', 'meta_description', 'meta_keyword',];
    public $meta_attributes = ['name','description', 'meta_title', 'meta_description', 'meta_keyword'];

    protected $fillable = [
        'model', 'is_active',
    ];


    // Attribute
    
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value),
        );
    }
}

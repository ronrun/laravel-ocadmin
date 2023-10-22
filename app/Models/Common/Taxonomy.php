<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;

class Taxonomy extends Model
{
    use ModelTrait;
    
    public $translation_model_name = 'TaxonomyMeta';
    public $translation_attributes = ['name','short_name'];
    public $meta_attributes = ['name','short_name'];
    protected $guarded = [];
   

    // Attributes

}

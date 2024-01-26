<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;

class Term extends Model
{
    use ModelTrait;
    
    public $translation_attributes = ['name',];
    public $translation_model_name = '\App\Models\Common\TermMeta';
    public $meta_model_name = '\App\Models\Common\TermMeta';
    protected $appends = ['name'];
    protected $guarded = [];
    private $translation_data = [];
   

    // Attributes
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getTranslationColumnsValues()['name'] ?? '',
        );
    }
    

}

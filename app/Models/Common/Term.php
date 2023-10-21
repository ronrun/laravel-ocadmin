<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;

class Term extends Model
{
    use ModelTrait;

    public $translation_model_name = 'TermMeta';
    public $translation_attributes = ['name',];
    public $meta_attributes = ['name'];
    protected $guarded = [];
    protected $appends = ['name','slug','description',];


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

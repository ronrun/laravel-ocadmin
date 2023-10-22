<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;
use App\Models\Common\Taxonomy;

class Term extends Model
{
    use ModelTrait;

    public $translation_model_name = 'TermMeta';
    public $translation_attributes = ['name',];
    public $meta_attributes = ['name'];
    protected $guarded = [];


    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id');
    }

}

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
    public $translation_attributes = ['name','short_name'];
    public $meta_attributes = ['name','short_name'];
    protected $guarded = [];


    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id');
    }

    public function paths()
    {
        return $this->hasMany(TermPath::class, 'term_id', 'id');
    }

}

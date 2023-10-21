<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;
use App\Models\Common\Term;

class Option extends Term
{
    use ModelTrait;
    
    protected $guarded = [];
    protected $appends = ['name','content','slug'];

    public $translation_attributes = ['name', 'content', 'slug',];

    public function option_values()
    {
        return $this->hasMany(OptionValue::class, 'parent_id', 'id');
    }
}

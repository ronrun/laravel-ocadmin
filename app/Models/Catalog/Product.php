<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelTrait;
use App\Models\Catalog\ProductMeta;

class Product extends Model
{
    use ModelTrait;
    use SoftDeletes;

    protected $guarded = [];
    protected $appends = ['name','specification','description','meta_title','meta_description','meta_keyword'];
    public $translation_attributes = ['name','short_name','specification','description','meta_title','meta_description','meta_keyword',];
    public $translation_type = 'meta-table';
    
    //
    public $meta_keys = [
    ];
}

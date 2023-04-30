<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;
    public $foreign_key = 'product_id';
    protected $guarded = [];
}

<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class OptionValue extends Model
{
    public $translation_attributes = ['name', 'content', 'slug',];
}

<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TranslatableTrait;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class OptionValue extends Model
{
    use TranslatableTrait;

    public $translatedAttributes = ['name', 'content', 'slug',];
}

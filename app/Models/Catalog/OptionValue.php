<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\TranslatableTrait;
use App\Traits\ModelTrait;
use App\Models\Catalog\Product;
use Carbon\Carbon;

class OptionValue extends Model
{
    use TranslatableTrait;
    use ModelTrait;

    protected $table = 'terms';
    protected $guarded = [];
    protected $appends = ['name','slug','description',];

    public $translated_attributes = ['name','short_name'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    // Attribute
    protected function optionValueId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->id,
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->name,
        );
    }

    protected function shortName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->short_name,
        );
    }
}

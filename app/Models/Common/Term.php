<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;
use App\Traits\TranslatableTrait;

class Term extends Model
{
    use TranslatableTrait;
    use ModelTrait;
    
    protected $guarded = [];
    protected $appends = ['name','slug','description',];

    public $translatedAttributes = ['name', 'description', 'slug',];
    public $translationForeignKey = 'term_id';


    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->name ?? '',
        );
    }

    protected function content(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->content ?? '',
        );
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->slug ?? '',
        );
    }

}

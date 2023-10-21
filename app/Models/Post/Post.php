<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;

class Post extends Model
{
    use ModelTrait;
    
    protected $guarded = [];
    protected $appends = ['name','content','slug'];

    public $translation_attributes = ['name', 'content','slug'];
    public $translationForeignKey = 'post_id';

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->name ?? '',
        );
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->slug ?? '',
        );
    }

    protected function content(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->translation->content ?? '',
        );
    }

}

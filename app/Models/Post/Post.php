<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Post extends Model
{
    use ModelTrait;
    
    public $translation_attributes = ['title', 'content', 'meta_title', 'meta_description', 'meta_keyword'];
    public $translation_model_name = '\App\Models\Common\PostMeta';
    public $meta_model_name = '\App\Models\Common\PostMeta';
    protected $appends = ['name'];
    protected $guarded = [];
    private $translation_data = []; //key-value pairs
}

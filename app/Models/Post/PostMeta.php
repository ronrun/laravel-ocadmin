<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    public $timestamps = false;
    protected $guarded = [];


    public function master()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}

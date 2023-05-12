<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use App\Models\Common\Term;

class Tag extends Term
{
    protected $guarded = [];
    protected $table = 'terms';

}

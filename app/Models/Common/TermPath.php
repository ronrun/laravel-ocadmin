<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;

class TermPath extends Model
{
    use ModelTrait;

    public $timestamps = false;    
    protected $guarded = [];


    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }

    public function path()
    {
        return $this->belongsTo(Term::class, 'path_id', 'id');
    }

}

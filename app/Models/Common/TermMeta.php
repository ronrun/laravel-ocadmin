<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class TermMeta extends Model
{
    public $timestamps = false;    
    protected $guarded = [];


    public function master()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}

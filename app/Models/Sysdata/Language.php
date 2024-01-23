<?php

namespace App\Models\Sysdata;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Language extends Model
{
    use ModelTrait;

    public $timestamps = false;
    public $connection = 'sysdata';
    protected $table = 'languages';
    protected $guarded = [];
    
}
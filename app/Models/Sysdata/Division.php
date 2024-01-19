<?php

namespace App\Models\Sysdata;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    public $timestamps = false;
    public $connection = 'sysdata';
    protected $table = 'divisions';
    protected $guarded = [];


    
}

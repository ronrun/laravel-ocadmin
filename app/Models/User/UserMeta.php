<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Usermeta extends Model
{
    protected $table = 'user_metas';
    public $timestamps = false; //must be public
}

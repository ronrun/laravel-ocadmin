<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = 'user_metas';
    public $timestamps = false; //must be public
}

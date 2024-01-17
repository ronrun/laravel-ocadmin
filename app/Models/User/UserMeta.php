<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User\User;

class UserMeta extends Model
{
    public $timestamps = false;    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

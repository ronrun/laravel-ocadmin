<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\User;

class UserMeta extends Model
{
    use SoftDeletes;
    
    public $timestamps = false;    
    protected $guarded = [];
    protected $primaryKey = ['user_id', 'locale', 'meta_key'];
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

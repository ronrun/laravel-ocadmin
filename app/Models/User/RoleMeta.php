<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User\Role;
use App\Traits\ModelTrait;

class RoleMeta extends Model
{
    use ModelTrait;
    
    public $timestamps = false;    
    protected $guarded = [];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
}

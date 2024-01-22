<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User\Permission;
use App\Traits\ModelTrait;

class PermissionMeta extends Model
{
    use ModelTrait;
    
    public $timestamps = false;    
    protected $guarded = [];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
    
}

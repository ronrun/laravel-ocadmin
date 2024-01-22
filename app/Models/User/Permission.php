<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\ModelTrait;
use App\Models\User\PermissionMeta;

class Permission extends Model
{
    use ModelTrait;

    protected $guarded = [];
    protected $appends = ['name',];
    public $translation_attributes = ['name',];


    public $meta_keys = [
    ];

    public function metas()
    {
        return $this->hasMany(PermissionMeta::class, 'permission_id', 'id');
    }
}

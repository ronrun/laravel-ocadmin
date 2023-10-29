<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class PermissionTranslation extends Model
{
    public $translation_attributes = ['name'];
    public $timestamps = false;

    protected $guarded = [];

}

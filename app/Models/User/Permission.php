<?php

namespace App\Models\User;

use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Traits\ModelTrait;

class Permission extends SpatiePermission
{
    use ModelTrait;
    
}

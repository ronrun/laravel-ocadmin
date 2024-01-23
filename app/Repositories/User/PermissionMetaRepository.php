<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\User\Permission;
use App\Models\User\PermissionMeta;

class PermissionMetaRepository extends Repository
{
    public $modelName = "\App\Models\User\PermissionMeta";
}
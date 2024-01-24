<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\User\Role;
use App\Models\User\RoleMeta;

class RoleMetaRepository extends Repository
{
    public $modelName = "\App\Models\User\RoleMeta";
}
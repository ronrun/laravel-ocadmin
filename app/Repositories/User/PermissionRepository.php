<?php

namespace App\Repositories\User;

use App\Repositories\Repository;
use App\Models\User\Permission;
use App\Models\Common\TermPath;
use Illuminate\Support\Facades\DB;

class PermissionRepository extends Repository
{
    protected $model_name = "\App\Models\User\Permission";

    public function __construct()
    {
        if (method_exists(get_parent_class($this), '__construct')) {
            parent::__construct();
        }

        $this->getLang(['ocadmin/common/common','ocadmin/user/permission']);
    }

    public function getPermissions($data = [], $debug = 0): mixed
    {
        $rows = parent::getRows($data, $debug);

        return $rows;
    }


    public function savePermission($post_data, $debug = 0)
    {
        try {
            $permission_id = $post_data['permission_id'] ?? $post_data['id'] ?? null;

            $result = $this->saveRow($permission_id, $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']);
            }

            return $result;

        } catch (\Exception $ex) {
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }
}


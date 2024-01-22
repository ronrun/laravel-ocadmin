<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\User\Permission;
use App\Models\User\PermissionMeta;

class PermissionMetaRepository extends Repository
{
    public $modelName = "\App\Models\User\PermissionMeta";

    public function save(Permission $user, $data)
    {
        try {
            DB::beginTransaction();   

            $meta_data = $this->setMetaSaveData($user, $data);

            PermissionMeta::where('user_id', $user->id)->delete();

            $result = PermissionMeta::upsert($meta_data, ['locale','user_id','meta_key']);
            
            DB::commit();

            return $meta_data;

        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage()];
        }
    }
}
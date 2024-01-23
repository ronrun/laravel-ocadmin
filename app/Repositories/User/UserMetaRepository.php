<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\User\User;
use App\Models\User\UserMeta;

class UserMetaRepository extends Repository
{

    public $modelName = "\App\Models\User\UserMeta";

    public function save(User $user, $data)
    {
        try {

            //要強制刪除的 meta_key
            if(isset($data['is_admin']) && $data['is_admin'] == 0){
                $this->forceDeleteMeta($user, ['is_admin']);
            }

            return $this->saveMeta($user, $data);

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
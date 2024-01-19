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
            DB::beginTransaction();   

            $meta_data = $this->setMetaSaveData($user, $data);

            UserMeta::where('user_id', $user->id)->delete();

            $result = UserMeta::upsert($meta_data, ['locale','user_id','meta_key']);
            
            DB::commit();

            return $meta_data;

        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage()];
        }
    }
}
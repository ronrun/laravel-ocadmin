<?php

namespace App\Repositories\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\User\Role;
use App\Models\User\RoleMeta;


class RoleRepository extends Repository
{
    public $modelName = "\App\Models\User\Role";

    /**
     * 注意！！
     * 由於 spatie role 套件的 name 欄位影響本系統設計原則，因此 translation 要另外處理。
     */

    public function getRoles($data = [], $debug = 0)
    {
        $data = $this->resetQueryData($data);

        // 一律移除 translation 關聯
        $data['with'] = Arr::get($data['with'] ?? [], 'translation');
        
        // 必要參數，否則 getRows() 會自動加上 translation
        $data['no_meta_translation'] = true;

        if(!empty($data['filter_keyword'])){
            $data['filter_name'] = $data['filter_keyword'];
            unset($data['filter_keyword']);
        }
        $roles = $this->getRows($data, $debug);
        

        foreach($roles as $role){
            $role = $this->setTranslationMetasToRow($role);
        }
        
        return $roles;
    }

    /**
     * @last_modified 2024-01-19
     */
    public function save($id = null, $data)
    {

        $data['guard_name'] = 'web';

        try {
            DB::beginTransaction();
            
            $role = $this->saveRow($data['role_id'], $data);

            DB::commit();

            return ['data' => $role];

        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * @last_modified 2024-01-18
     */
    public function destroy($ids, $debug = 0)
    {
        try {
            DB::beginTransaction();

            RoleMeta::whereIn('role_id', $ids)->delete();
            Role::whereIn('id', $ids)->delete();
            
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => $ex->getMessage()];
        }
    }

    /**
     * @last_modified 2024-01-18
     */
    private function resetQueryData($data)
    {
        if(!empty($data['filter_keyword'])){
            $data['translation']['andOrWhere'][] = [
                'trans_name' => $data['filter_keyword'],
                'nice_name' => $data['filter_keyword'],
            ];
            unset($data['filter_keyword']);
        }

        return $data;
    }

}
<?php

namespace App\Repositories\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\User\Permission;
use App\Models\User\PermissionMeta;


class PermissionRepository extends Repository
{
    public $modelName = "\App\Models\User\Permission";

    /**
     * 注意！！
     * 由於 spatie permission 套件的 name 欄位影響本系統設計原則，因此 translation 要另外處理。
     */

    public function getPermissions($data = [], $debug = 0)
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
        $permissions = $this->getRows($data, $debug);
        

        foreach($permissions as $permission){
            $permission->code = $permission->name;
            $permission = $this->setTranslationMetasToRow($permission);
        }
        
        return $permissions;
    }

    /**
     * @last_modified 2024-01-19
     */
    public function save($id = null, $data)
    {
        $data['guard_name'] = 'web';

        try {
            DB::beginTransaction();
            
            $permission = $this->saveRow($data['permission_id'], $data);

            DB::commit();

            return ['data' => $permission];

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

            PermissionMeta::whereIn('permission_id', $ids)->delete();
            Permission::whereIn('id', $ids)->delete();
            
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
            ];
            unset($data['filter_keyword']);
        }

        return $data;
    }

}
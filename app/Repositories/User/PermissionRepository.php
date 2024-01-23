<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\Permission\Permission;
use App\Models\Permission\PermissionMeta;
use Illuminate\Support\Arr;

class PermissionRepository extends Repository
{
    public $modelName = "\App\Models\User\Permission";

    /**
     * 注意！！
     * 由於 spatie permission 套件的 name 欄位影響本系統設計原則，因此 translation 要另外處理。
     * 本站主表原則：id, code
     * 本站翻譯表原則：id, locale, permission_id, meta_key, meta_value
     * spatie permission 套件的 permissions 資料表：id, name, guard_name。
     * 因此，取出後，name即code, 令 code=name，然後令 name=翻譯表的name
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
     * 注意自訂 code 欄位與主表 name的轉換。
     * @last_modified 2024-01-19
     */
    public function save($id = null, $data)
    {
        $data['name'] = $data['code'];
        unset($data['code']);

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
    private function resetQueryData($data)
    {
        if(!empty($data['filter_phone'])){

            $data['andOrWhere'][] = [
                'filter_mobile' => $data['filter_phone'],
                'filter_telephone' => $data['filter_phone'],
                'filter_shipping_phone' => $data['filter_phone'],
            ];
            unset($data['filter_phone']);
        }

        if(!empty($data['filter_name'])){
            $data['andOrWhere'][] = [
                'filter_name' => $data['filter_name'],
                'filter_shipping_recipient' => $data['filter_name'],
            ];
            unset($data['filter_name']);
        }

        return $data;
    }

}
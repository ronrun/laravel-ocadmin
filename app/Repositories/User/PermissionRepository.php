<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\Permission\Permission;
use App\Models\Permission\PermissionMeta;

class PermissionRepository extends Repository
{
    public $modelName = "\App\Models\User\Permission";


    public function getPermissions($data = [], $debug = 0)
    {
        $data = $this->resetQueryData($data);

        if(!empty($data['filter_keyword'])){
            $data['filter_name'] = $data['filter_keyword'];
            unset($data['filter_keyword']);
        }
        $permissions = $this->getRows($data, $debug);

        return $permissions;
    }
    
    
    public function getAdminPermissions($query_data,$debug=0)
    {
        $query_data['whereHas']['permissionMeta'] = ['meta_key' => 'is_admin', 'meta_value' => 1];

        $permissions = $this->getRows($query_data);

        return $permissions;
    }

    public function getAdminPermissionIds()
    {
        return PermissionMeta::where('meta_key', 'is_admin')->where('meta_value', 1)->pluck('permission_id');
    }

    /**
     * @last_modified 2024-01-18
     */
    public function destroy($ids, $debug = 0)
    {
        try {
            DB::beginTransaction();

            //PermissionAddress::whereIn('permission_id', $ids)->delete();
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
    public function deleteId($permission_id)
    {
        try {

            DB::beginTransaction();

            //PermissionAddress::where('permission_id', $permission_id)->delete();
            PermissionMeta::where('permission_id', $permission_id)->delete();
            Permission::where('id', $permission_id)->delete();

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => $ex->getMessage()];
        }
    }

    /**
     * @last_modified 2024-01-19
     */
    public function save($id = null, $data)
    {
        DB::beginTransaction();

        try {
            //比對資料表欄位
            $permission_data = $this->setSaveData($data['permission_id'], $data);

            //額外處理
            if($id === null && empty($permission_data['password'])){ // 新增若無密碼，則設為空值
                $permission_data['password'] = '';
            }else if(empty($permission_data['password'])){ //修改若無密碼，則不處理password
                unset($permission_data['password']);
            }

            $permission = $this->findIdOrNew($id);

            foreach ($permission_data as $column => $value) {
                $permission->{$column} = $value;
            }

            //有異動才更新
            if($permission->isDirty()){
                $permission->save();
            }

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
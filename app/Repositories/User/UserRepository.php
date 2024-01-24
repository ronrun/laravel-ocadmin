<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\User\User;
use App\Models\User\UserMeta;
use App\Repositories\Common\TermRepository;

class UserRepository extends Repository
{
    public $modelName = "\App\Models\User\User";


    public function getUsers($data = [], $debug = 0)
    {
        $data = $this->resetQueryData($data);

        $users = $this->getRows($data, $debug);

        return $users;
    }
    
    
    public function getAdminUsers($query_data,$debug=0)
    {
        $query_data['whereHas']['userMeta'] = ['meta_key' => 'is_admin', 'meta_value' => 1];

        $users = $this->getRows($query_data);

        return $users;
    }

    public function getAdminUserIds()
    {
        return UserMeta::where('meta_key', 'is_admin')->where('meta_value', 1)->pluck('user_id');
    }

    /**
     * @last_modified 2024-01-18
     */
    public function destroy($ids, $debug = 0)
    {
        try {
            DB::beginTransaction();

            //UserAddress::whereIn('user_id', $ids)->delete();
            UserMeta::whereIn('user_id', $ids)->delete();
            User::whereIn('id', $ids)->delete();
            
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => $ex->getMessage()];
        }
    }

    /**
     * @last_modified 2024-01-18
     */
    public function deleteId($user_id)
    {
        try {

            DB::beginTransaction();

            //UserAddress::where('user_id', $user_id)->delete();
            UserMeta::where('user_id', $user_id)->delete();
            User::where('id', $user_id)->delete();

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

            //額外處理
            if($id == null && empty($data['password'])){ // 新增時若無密碼，則設為空值
                $data['password'] = '';
            }else if(!empty($id) && empty($data['password'])){ //修改時若無密碼，則不處理password
                unset($data['password']);
            }

            //儲存
            $user = $this->saveRow($data['user_id'], $data);

            DB::commit();

            return ['data' => $user];

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

        if(!empty($data['filter_keyword'])){
            $data['andOrWhere'][] = [
                'filter_name' => $data['filter_keyword'],
                'filter_shipping_recipient' => $data['filter_keyword'],
            ];
            unset($data['filter_keyword']);
        }

        return $data;
    }

}
<?php

namespace App\Domains\Admin\Services\User;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;
use App\Libraries\TranslationLibrary;

class UserService extends Service
{
    public $modelName;
    public $model;
    public $table;
    public $lang;

	public function __construct()
	{
        $this->modelName = "\App\Models\User\User";
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/user/user']);
	}


    public function updateOrCreate($data)
    {
        DB::beginTransaction();

        try {
            if(!empty($data['user_id'])){
                $record = $this->getRecordByIdOrFail($data['user_id']);
            }else{
                $record = $this->newModel();
            }
            $record->display_name = $data['display_name'];
            $record->user_nicename = $data['display_name'];
            $record->email = $data['email'] ?? '';
            //$record->mobile = str_replace('-','',$data['mobile']) ?? '';
            $record->save();

            DB::commit();

            $result['data']['user_id'] = $record->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = $ex->getMessage();
            return $result;
        }
    }

}

<?php

namespace App\Domains\Admin\Services\User;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;
use App\Libraries\TranslationLibrary;

class PermissionService extends Service
{
    public $modelName;
    public $model;
    public $table;
    public $lang;

	public function __construct()
	{
        $this->modelName = 'Spatie\Permission\Models\Permission';
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/user/permission']);
	}


    public function updateOrCreate($data)
    {
        DB::beginTransaction();

        try {
            if(!empty($data['permission_id'])){
                $record = $this->getRecordByIdOrFail($data['permission_id']);
            }else{
                $record = $this->newModel();
            }

            $record->name = $data['name'];
            $record->guard_name = 'web';
            $record->save();

            DB::commit();

            $result['data']['permission_id'] = $record->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = $ex->getMessage();
            return $result;
        }
    }

}
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
        $this->modelName = 'App\Models\User\Permission';
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/user/permission']);
	}


    public function updateOrCreate($data)
    {
        DB::beginTransaction();

        try {
            $record = $this->findOrFailOrNew(id:$data['permission_id']);

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
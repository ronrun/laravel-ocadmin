<?php

namespace App\Domains\Admin\Services\User;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;
use App\Libraries\TranslationLibrary;

class RoleService extends Service
{
    public $modelName;
    public $model;
    public $table;
    public $lang;

	public function __construct()
	{
        $this->modelName = "Spatie\Permission\Models\Role";
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/user/role']);
	}


    public function updateOrCreate($data)
    {
        DB::beginTransaction();

        try {
            $record = $this->findOrFailOrNew($data['user_id']);
            $record->name = $data['name'];
            $record->email = $data['email'] ?? '';
            $record->mobile = str_replace('-','',$data['mobile']) ?? '';
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

<?php

namespace App\Domains\Admin\Services\User;

use App\Domains\Exceptions\NotFoundException;
use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;
use App\Libraries\TranslationLibrary;

class UserService extends Service
{
    public $model_name;
    public $model;
    public $table;
    public $lang;

	public function __construct()
	{
        $this->model_name = "\App\Models\User\User";
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/user/user']);
	}

    public function getUsers($data)
    {
        $data['WhereRawSqls'][] = "is_admin=1";
        
        return $this->getRows($data);

    }


    public function updateOrCreate($data)
    {
        DB::beginTransaction();

        try {
            $record = $this->findOrFailOrNew(id:$data['user_id']);

            $record->display_name = $data['display_name'];
            //$record->user_nicename = $data['user_nicename'] ?? $data['display_name'] ?? '';
            $record->email = $data['email'] ?? '';
            //$record->mobile = str_replace('-','',$data['mobile']) ?? '';
            
            $record->save();

            if($record->wasRecentlyCreated){
                // do something
            }

            DB::commit();

            $result['user_id'] = $record->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => 'Exception error: code="' . $ex->getCode() . '", ' . $ex->getMessage()];
        }
    }

}

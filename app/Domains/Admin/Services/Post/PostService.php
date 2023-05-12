<?php

namespace App\Domains\Admin\Services\Post;

use App\Domains\Exceptions\NotFoundException;
use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;
use App\Libraries\TranslationLibrary;

class PostService extends Service
{
    public $modelName;
    public $model;
    public $table;
    public $lang;

	public function __construct()
	{
        $this->modelName = "\App\Models\Post\Tag";
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/user/user']);
	}


    public function updateOrCreate($data)
    {
        DB::beginTransaction();

        try {
            $record = $this->findOrFailOrNew($data['user_id']);

            $record->display_name = $data['display_name'];
            $record->user_nicename = $data['user_nicename'] ?? $data['display_name'] ?? '';
            $record->email = $data['email'] ?? '';
            //$record->mobile = str_replace('-','',$data['mobile']) ?? '';
            
            $record->save();

            if($record->wasRecentlyCreated){
                // do something
            }

            DB::commit();

            $result['data']['user_id'] = $record->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Exception error: code=' . $ex->getCode() . ', ' . $ex->getMessage();
            return $result;
        }
    }

}

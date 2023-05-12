<?php

namespace App\Domains\Admin\Services\Post;

use App\Domains\Exceptions\NotFoundException;
use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;

class TagService extends Service
{
    public $modelName;
    public $model;
    public $table;
    public $lang;

	public function __construct()
	{
        $this->modelName = "\App\Models\Post\Tag";
	}


    public function updateOrCreate($data)
    {
        DB::beginTransaction();

        try {
            $record = $this->findOrFailOrNew($data['tag_id']);

            $record->name = $data['name'];
            
            $record->save();

            if($record->wasRecentlyCreated){
                // do something
            }

            DB::commit();

            $result['data']['record_id'] = $record->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }

}

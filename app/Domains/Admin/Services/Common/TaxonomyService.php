<?php

namespace App\Domains\Admin\Services\Common;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;

class TaxonomyService extends Service
{
    public $modelName = "\App\Models\Common\Taxonomy";
    public $model;
    public $table;
    public $lang;


    public function getPosts($data)
    {        
        return $this->getRecords($data);
    }


    public function save($data)
    {
        DB::beginTransaction();

        try {
            $post = $this->findOrFailOrNew(id:$data['post_id']);
            $this->saveModelInstance($post, $data);

            if(!empty($data['post_translations'])){
                $this->saveTranslationData($post, $data['post_translations']);
            }

            DB::commit();

            $result['data']['record_id'] = $post->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }

}

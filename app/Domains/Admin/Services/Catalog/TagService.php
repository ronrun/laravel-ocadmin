<?php

namespace App\Domains\Admin\Services\Catalog;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;

class TagService extends Service
{
    public $modelName = "\App\Models\Common\Term";
    public $model;
    public $table;
    public $lang;


    public function getTags($data)
    {
        $data['WhereRawSqls'][] = "taxonomy='product_tag'";
        
        return $this->getRecords($data);
    }


    public function save($data)
    {
        DB::beginTransaction();

        try {
            $tag = $this->findOrFailOrNew(id:$data['tag_id']);
            $tag->taxonomy = 'post_tag';
            $this->saveModelInstance($tag, $data);

            if(!empty($data['tag_translations'])){
                $this->saveTranslationData($tag, $data['tag_translations']);
            }

            DB::commit();

            $result['data']['record_id'] = $tag->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }

}

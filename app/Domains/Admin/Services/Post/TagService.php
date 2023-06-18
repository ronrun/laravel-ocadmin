<?php

namespace App\Domains\Admin\Services\Post;

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
        $data['WhereRawSqls'][] = "taxonomy_code='post_tag'";
        
        return $this->getRecords($data);
    }


    public function save($data)
    {
        DB::beginTransaction();

        try {
            $tag = $this->findOrFailOrNew(id:$data['tag_id']);
            $tag->taxonomy_code = 'post_tag';
            $this->saveModelInstance($tag, $data);

            if(!empty($data['translations'])){
                $this->saveTranslationData($tag, $data['translations']);
            }

            DB::commit();

            $result['tag_id'] = $tag->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => 'Exception error: code="' . $ex->getCode() . '", ' . $ex->getMessage()];
        }
    }

}

<?php

namespace App\Domains\Admin\Services\Catalog;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;

class TagService extends Service
{
    public $model_name = "\App\Models\Common\Term";
    public $model;
    public $table;
    public $lang;


    public function getTags($data, $debug=0)
    {
        $data['WhereRawSqls'][] = "taxonomy_code='product_tag'";
        
        return $this->getRows($data, $debug);
    }


    public function save($data)
    {
        DB::beginTransaction();

        try {
            $tag = $this->findOrFailOrNew(id:$data['tag_id']);
            $tag->taxonomy_code = 'product_tag';
            $this->saveModelInstance($tag, $data);

            if(!empty($data['translations'])){
                $this->saveTranslationData($tag, $data['translations']);
            }

            DB::commit();

            $result['tag_id'] = $tag->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => $ex->getMessage()];
        }
    }

}

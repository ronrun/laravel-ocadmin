<?php

namespace App\Domains\Admin\Services\Post;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;

class CategoryService extends Service
{
    public $modelName = "\App\Models\Common\Term";
    public $model;
    public $table;
    public $lang;


    public function getCategories($data)
    {
        $data['WhereRawSqls'][] = "taxonomy='post_category'";
        
        return $this->getRecords($data);
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {
            $category = $this->findOrFailOrNew(id:$data['category_id']);
            $category->taxonomy = 'post_category';
            $this->saveModelInstance($category, $data);

            if(!empty($data['category_translations'])){
                $this->saveTranslationData($category, $data['category_translations']);
            }

            DB::commit();

            $result['data']['record_id'] = $category->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }

}

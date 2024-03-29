<?php

namespace App\Domains\Admin\Services\Post;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;

class CategoryService extends Service
{
    public $model_name = "\App\Models\Common\Term";
    public $model;
    public $table;
    public $lang;


    public function getCategories($data)
    {
        $data['WhereRawSqls'][] = "taxonomy_code='post_category'";
        
        return $this->getRows($data);
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {
            $category = $this->findOrFailOrNew(id:$data['category_id']);
            $category->taxonomy_code = 'post_category';
            $this->saveModelInstance($category, $data);

            if(!empty($data['translations'])){
                $this->saveTranslationData($category, $data['translations']);
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

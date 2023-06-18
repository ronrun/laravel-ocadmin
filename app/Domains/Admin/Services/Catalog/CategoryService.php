<?php

namespace App\Domains\Admin\Services\Catalog;

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
        $data['WhereRawSqls'][] = "taxonomy_code='product_category'";        
        return $records = $this->getRecords($data);
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {
            $category = $this->findOrFailOrNew(id:$data['category_id']);
            $category->taxonomy_code = 'product_category';
            $this->saveModelInstance($category, $data);

            if(!empty($data['translations'])){
                $this->saveTranslationData($category, $data['translations']);
            }

            DB::commit();

            $result['category_id'] = $category->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => 'Exception error: code="' . $ex->getCode() . '", ' . $ex->getMessage()];
        }
    }

}

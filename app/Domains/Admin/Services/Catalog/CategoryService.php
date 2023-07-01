<?php

namespace App\Domains\Admin\Services\Catalog;

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
        $data['WhereRawSqls'][] = "taxonomy_code='product_category'";        
        return $records = $this->getRows($data);
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {
            $term = $this->findOrFailOrNew(id:$data['category_id']);
            $term->taxonomy_code = 'product_category';
            $this->saveModelInstance($term, $data);

            if(!empty($data['translations'])){
                $this->saveTranslationData($term, $data['translations']);
            }

            DB::commit();

            $result['category_id'] = $term->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => $ex->getMessage()];
        }
    }

}

<?php

namespace App\Domains\Admin\Services\Catalog;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;

class AttributeService extends Service
{
    public $model_name = "\App\Models\Common\Term";
    public $model;
    public $table;
    public $lang;


    public function getCategories($data)
    {
        $data['WhereRawSqls'][] = "taxonomy_code='product_attribute'";        
        return $records = $this->getRows($data);
    }

    public function save($data)
    {
        DB::beginTransaction();

        try {
            $term = $this->findOrFailOrNew(id:$data['term_id']);
            $term->taxonomy_code = 'product_attribute';
            $this->saveModelInstance($term, $data);

            if(!empty($data['translations'])){
                $this->saveTranslationData($term, $data['translations']);
            }

            DB::commit();

            $result['term_id'] = $term->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => $ex->getMessage()];
        }
    }

}

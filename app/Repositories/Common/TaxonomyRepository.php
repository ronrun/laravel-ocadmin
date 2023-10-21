<?php

namespace App\Repositories\Common;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\Common\Taxonomy;

class TaxonomyRepository extends Repository
{
    protected $model_name = "\App\Models\Common\Taxonomy";

    public function getTaxonomy($data = [], $debug = 0): mixed
    {
        return parent::getRows($data, $debug);
    }


    public function saveTaxonomy($post_data, $debug = 0)
    {
        try {
            $taxonomy_id = $post_data['taxonomy_id'] ?? $post_data['id'];

            // 這裡不能用 DB::beginTransaction(); 否則 saveRow 無效
            $result = $this->saveRow($taxonomy_id, $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']);
            }
    
            return $result;

        } catch (\Exception $ex) {
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }
}


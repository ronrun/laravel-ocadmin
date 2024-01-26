<?php

namespace App\Repositories\Common;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\Common\Taxonomy;
use App\Models\Common\TaxonomyMeta;


class TaxonomyRepository extends Repository
{
    public $modelName = "\App\Models\Common\Taxonomy";

    public function getTaxonomies($data = [], $debug = 0)
    {
        $data = $this->resetQueryData($data);
        
        $rows = $this->getRows($data, $debug);
        
        foreach($rows as $row){
            $row = $this->setTranslationMetasToRow($row);
        }
        
        return $rows;
    }


    public function save($id = null, $data)
    {
        try {
            DB::beginTransaction();
            
            $taxonomy = $this->saveRow($data['taxonomy_id'], $data);

            DB::commit();

            return ['data' => $taxonomy];

        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * @last_modified 2024-01-18
     */
    public function destroy($ids, $debug = 0)
    {
        try {
            DB::beginTransaction();

            TaxonomyMeta::whereIn('taxonomy_id', $ids)->delete();
            Taxonomy::whereIn('id', $ids)->delete();
            
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => $ex->getMessage()];
        }
    }

    private function resetQueryData($data)
    {
        return $data;
    }

}
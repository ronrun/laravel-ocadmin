<?php

namespace App\Repositories\Common;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\Common\Term;
use App\Models\Common\TermMeta;


class TermRepository extends Repository
{
    public $modelName = "\App\Models\Common\Term";

    public function getTerms($data = [], $debug = 0)
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
            
            $term = $this->saveRow($data['term_id'], $data);

            DB::commit();

            return ['data' => $term];

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

            TermMeta::whereIn('term_id', $ids)->delete();
            Term::whereIn('id', $ids)->delete();
            
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => $ex->getMessage()];
        }
    }

    private function resetQueryData($data)
    {
        if(!empty($data['filter_keyword'])){
            $data['translation']['andOrWhere'][] = [
                'name' => $data['filter_keyword'],
            ];
            unset($data['filter_keyword']);
        }

        return $data;
    }

}
<?php

namespace App\Domains\Admin\Services\Common;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;

class TermService extends Service
{
    public $modelName = "\App\Models\Common\Term";
    public $model;
    public $table;
    public $lang;


    public function getPosts($data)
    {        
        return $this->getRecords($data);
    }


    public function save($data)
    {
        DB::beginTransaction();

        try {
            $term = $this->findOrFailOrNew($data['term_id']);

            // do something

            $this->saveModelInstance($term, $data);

            if(!empty($data['translations'])){
                $this->saveTranslationData($term, $data['translations']);
            }

            DB::commit();

            $result['row_id'] = $term->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => $ex->getMessage()];
        }
    }

}

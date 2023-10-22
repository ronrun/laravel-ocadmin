<?php

namespace App\Repositories\Common;

use App\Repositories\Repository;
use App\Models\Common\Term;

class TermRepository extends Repository
{
    protected $model_name = "\App\Models\Common\Term";

    public function __construct()
    {
        if (method_exists(get_parent_class($this), '__construct')) {
            parent::__construct();
        }

        $this->getLang(['ocadmin/common/common','ocadmin/common/taxonomy']);
    }

    public function getTerm($data = [], $debug = 0): mixed
    {
        $row = parent::getRows($data, $debug);
		$extra_columns = $data['extra_columns'] ?? [];

        foreach ($extra_columns as $column) {
            if ($column === 'taxonomy_name' && !empty($row->taxonomy_id)) {
                $row->load('taxonomy.translation');
                $row->taxonomy_name = $row->taxonomy->translation[0]->meta_value;
                unset($row->taxonomy);
            }
        }
        
        return $row;
    }

    public function getTerms($data = [], $debug = 0): mixed
    {
        $rows = parent::getRows($data, $debug);
		$extra_columns = $data['extra_columns'] ?? [];

        $rows->load('taxonomy.translation');

        foreach ($rows as $row) {
            foreach ($extra_columns as $column) {
                if ($column === 'taxonomy_name' && !empty($row->taxonomy_id)) {
                    $row->taxonomy_name = $row->taxonomy->translation[0]->meta_value;
                    unset($row->taxonomy);
                }
            }
        }

        return $rows;
    }


    public function saveTerm($post_data, $debug = 0)
    {
        try {
            $term_id = $post_data['term_id'] ?? $post_data['id'] ?? null;

            // 這裡不能用 DB::beginTransaction(); 否則 saveRow 無效
            $result = $this->saveRow($term_id, $post_data);

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


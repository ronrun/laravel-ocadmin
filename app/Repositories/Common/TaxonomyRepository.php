<?php

namespace App\Repositories\Common;

use Illuminate\Support\Facades\DB;
use App\Repositories\Repository;
use App\Models\Common\Taxonomy;
use App\Models\Common\TaxonomyMeta;
use App\Models\Common\Term;

class TaxonomyRepository extends Repository
{
    protected $model_name = "\App\Models\Common\Taxonomy";

    public function __construct()
    {
        if (method_exists(get_parent_class($this), '__construct')) {
            parent::__construct();
        }

        $this->getLang(['ocadmin/common/common','ocadmin/common/taxonomy']);
    }

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


    public function deleteTaxonomy($taxonomy_id)
    {
        try {

            if($taxonomy_id < 1){
                return false;
            }

            DB::beginTransaction();

            //$taxonomy = Taxonomy::find($taxonomy_id);
            $taxonomy = parent::findIdOrFailOrNew($taxonomy_id);

            // Check
            $term_num = Term::where('taxonomy_id', $taxonomy_id)->count();
            if($term_num > 0){
                $result['error'] = $taxonomy->name . $this->lang->error_term_used;
            }
            
            if (isset($result['error'])) {
                return $result;
            }

            TaxonomyMeta::where('taxonomy_id', $taxonomy_id)->delete();
            Taxonomy::find($taxonomy_id)->delete();

            DB::commit();

            return ['success' => '刪除成功'];

        } catch (\Exception $ex) {
            DB::rollback();
            return ['error' => $ex->getMessage()];
        }
    }

}


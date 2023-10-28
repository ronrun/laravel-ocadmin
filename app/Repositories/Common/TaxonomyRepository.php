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

    public function getTaxonomies($data = [], $debug = 0): mixed
    {
        if(!empty($data['filter_keyword'])){
            $data['andWhere'][] = [ // where 條件第一層，跟主表 is_active 同層。一般情況下都使用 and
                'sub_type' => 'orWhere', // 同層的篩選使用 or
                'filter_code' => $data['filter_keyword'],
                'orWhere' => [[
                        'sub_type' => 'orWhere',
                        'filter_name' => $data['filter_keyword'],
                    ],[
                        'sub_type' => 'orWhere',
                        'filter_short_name' => $data['filter_keyword'], 
                    ],
                ],
            ];
            unset($data['filter_keyword']);
        }
        
        return parent::getRows($data, $debug);
    }


    public function saveTaxonomy($post_data, $debug = 0)
    {
        try {
            $taxonomy_id = $post_data['taxonomy_id'] ?? $post_data['id'] ?? null;

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


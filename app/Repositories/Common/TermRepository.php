<?php

namespace App\Repositories\Common;

use App\Repositories\Repository;
use App\Models\Common\Term;
use App\Models\Common\TermPath;
use Illuminate\Support\Facades\DB;

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
        if(!empty($data['filter_keyword'])){
            $data['andWhere'][] = [ // where 條件第一層，跟主表 is_active 同層。一般情況下都使用 and
                'sub_type' => 'orWhere', // 同層的篩選使用 or
                'filter_code' => $data['filter_keyword'],
                'orWhere' => [[
                        'sub_type' => 'orWhere',
                        'filter_name' => $data['filter_keyword'],
                    ],
                ],
            ];
            unset($data['filter_keyword']);
        }

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

            // term_paths 執行期間應該要鎖住資料表
            if(!empty($post_data['term_paths'])){

                // - delete
                DB::beginTransaction();
                //echo '<pre>term_paths ', print_r($post_data['term_paths'], 1), "</pre>"; exit;

                $existed_group_ids = TermPath::where('term_id', $term_id)->groupBy('group_id')->pluck('group_id')->toArray();
                $new_group_ids = array_column($post_data['term_paths'], 'group_id');
                $same_group_ids = array_intersect($existed_group_ids, $new_group_ids);

                $delete_group_ids = array_diff($existed_group_ids, $new_group_ids);

                TermPath::where('group_id', $delete_group_ids)->delete();
                
                // - upsert
                $new_group_id = TermPath::max('group_id') + 1;

                foreach ($post_data['term_paths'] as $term_path) {

                    if(in_array($term_path['group_id'] , $same_group_ids)){
                        continue;
                    }
                    
                    $refrence_term_paths = TermPath::where('group_id', $term_path['group_id'])->get();

                    $arr = [];
                    $level = 0;

                    // -- 產生歷代祖先資料
                    foreach ($refrence_term_paths as $path) {
                        $arr = [
                            'term_id' => $term_id,
                            'path_id' => $path->path_id,
                            'level' => $level,
                            'group_id' => $new_group_id,
                        ];

                        $term_path_rows[] = $arr;

                        $level ++;
                    }
                    // -- 產生當代資料
                    $arr = [
                        'term_id' => $term_id,
                        'path_id' => $term_id,
                        'level' => $level,
                        'group_id' => $new_group_id,
                    ];
                    $term_path_rows[] = $arr;
                    $new_group_id ++;
                }

                if(!empty($term_path_rows)){
                    TermPath::upsert($term_path_rows,['id']);
                }

                DB::commit();
            }

            return $result;

        } catch (\Exception $ex) {
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }

    public function getGroupedPathByTermId($term_id = [], $debug = 0)
    {
        $termPaths = TermPath::with('path')->where('term_id', $term_id)->orderBy('group_id')->orderBy('level')->get();

        $groupedTermPaths = $termPaths->groupBy('group_id');
        
        $result = [];
        foreach ($groupedTermPaths as $groupId => $paths) {
            $row = $paths->last()->toArray();
            $row['name'] = $paths->sortBy('level')->pluck('path.name')->implode(' > ');
            //$row['name'] = $paths->sortBy('level')->pluck('path.name')->implode(' > ') . ': id='.$row['id'].', group_id=' . $row['group_id'];
            unset($row['path']);

            $result[] = (object) $row;
        }

        return $result;
    }

    
    public function getGroupedPath($query_data = [], $debug = 0)
    {
        $termPaths = TermPath::with('path.translation')->orderBy('group_id')->orderBy('level')->get();

        $groupedTermPaths = $termPaths->groupBy('group_id');

        $result = [];
        foreach ($groupedTermPaths as $groupId => $paths) {
            foreach ($paths as $key => $path) {
                foreach ($path->path->translation as $translation) {
                    $column = $translation->meta_key;
                    $path->$column = $translation->meta_value;
                }
            }
            $row = $paths->last()->toArray();
            $row['name'] = $paths->sortBy('level')->pluck('name')->implode(' > ');
            unset($row['path']);

            $result[] = $row;
        }

        return $result;
    }

}


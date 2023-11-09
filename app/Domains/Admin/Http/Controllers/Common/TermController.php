<?php

namespace App\Domains\Admin\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Domains\Admin\Http\Controllers\BackendController;
use App\Http\Controllers\Controller;
use App\Domains\Admin\Services\Common\TermService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Helpers\Classes\UrlHelper;

use App\Models\Common\Term;
use App\Models\Common\TermPath;

class TermController extends BackendController
{
    protected $lang;
    
    public function __construct(private Request $request, private TermService $TermService, )
    {
        parent::__construct();
        $this->getLang(['ocadmin/common/common','ocadmin/common/term']);
    }

    public function index()
    {
        $data['lang'] = $this->lang;

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_system,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_term,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.common.terms.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $data['add_url'] = route('lang.admin.common.terms.form');
        $data['list_url'] = route('lang.admin.common.terms.list');
        $data['delete_url'] = route('lang.admin.common.terms.delete');
        
        $data['list'] = $this->getList();

        return view('ocadmin.common.term', $data);
    }

    public function list()
    {
        return $this->getList();
    }

    public function getList()
    {
        $data['lang'] = $this->lang;

        $queries = $this->request->query();

        // Prepare query_data for records
        $query_data = UrlHelper::getUrlQueries($queries);
        
        // Rows
        $query_data['extra_columns'] = ['taxonomy_name'];
        $terms = $this->TermService->getTerms($query_data);

        if(!empty($terms)){
            foreach ($terms as $row) {
                $row->edit_url = route('lang.admin.common.terms.form', array_merge([$row->id], $query_data));
            }
        }

        $terms = $terms->withPath(route('lang.admin.common.terms.list'))->appends($queries);

        // maybe do something

        $data['terms'] = $terms;

        $data['save_url'] = route('lang.admin.common.terms.save');
        $data['back_url'] = route('lang.admin.common.terms.index', $queries);
        $data['list_url'] = route('lang.admin.common.terms.list');



        // Prepare links for list table's header
        if($query_data['order'] == 'ASC'){
            $order = 'DESC';
        }else{
            $order = 'ASC';
        }
        
        $data['sort'] = strtolower($query_data['sort']);
        $data['order'] = strtolower($order);

        $query_data = UrlHelper::unsetUrlQueryData($queries,['sort','order']);

        $url = '';

        foreach($query_data as $key => $value){
            $url .= "&$key=$value";
        }


        // link of table header for sorting        
        $route = route('lang.admin.common.terms.list');

        $data['sort_id'] = $route . "?sort=id&order=$order" .$url;
        $data['sort_code'] = $route . "?sort=code&order=$order" .$url;
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_term'] = $route . "?sort=term&order=$order" .$url;
        $data['sort_taxonomy_code'] = $route . "?sort=taxonomy_code&order=$order" .$url;
        
        return view('ocadmin.common.term_list', $data);
    }

    public function form($term_id = null)
    {
        // Language
        $this->lang->text_form = empty($term_id) ? $this->lang->text_add : $this->lang->text_edit;

        $data['lang'] = $this->lang;

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_categories,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.common.terms.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        // Prepare link for save, back
        $queries = [];

        foreach($this->request->all() as $key => $value){
            if(strpos($key, 'filter_') !== false){
                $queries[$key] = $value;
            }
        }

        if(!empty($this->request->query('page'))){
            $queries['page'] = $this->request->query('page');
        }else{
            $queries['page'] = 1;
        }

        if(!empty($this->request->query('sort'))){
            $queries['sort'] = $this->request->query('sort');
        }else{
            $queries['sort'] = 'id';
        }

        if(!empty($this->request->query('order'))){
            $queries['order'] = $this->request->query('order');
        }else{
            $queries['order'] = 'DESC';
        }

        if(!empty($this->request->query('limit'))){
            $queries['limit'] = $this->request->query('limit');
        }

        $data['save_url'] = route('lang.admin.common.terms.save');
        $data['back_url'] = route('lang.admin.common.terms.index', $queries);
        $data['autocomplete_url'] = route('lang.admin.common.terms.autocomplete');

        // Get Record
        $term = $this->TermService->findIdOrFailOrNew(id:$term_id);
        // $filter_data = [
        //     'equal_id' => $term_id,
        //     'first' => true,
        //     'extra_columns' => ['taxonomy_name'],

        // ];
        // $term = $this->TermService->getTerm($filter_data,1);

        $data['term']  = $term;
        
        $data['term_id'] = $term_id ?? null;

        $data['supportedLocales'] = LaravelLocalization::getLocalesOrder();

        $data['translations'] = $term->sortedTranslations();

        $data['term_paths'] = $this->TermService->getGroupedPathByTermId($term_id);
        
        return view('ocadmin.common.term_form', $data);
    }

    public function save()
    {
        $post_data = $this->request->post();
        $queryData = $this->request->query();

        $json = [];

        // validate
        foreach ($post_data['translations'] as $locale => $translation) {
            if(empty($translation['name']) || mb_strlen($translation['name']) > 60){
                $json['error']['name-' . $locale] = $this->lang->error_name;
            }
        }

        if(empty($post_data['taxonomy_id']) || empty($post_data['taxonomy_code'])){
            $json['error']['taxonomy_name'] = $this->lang->error_taxonomy_name;
        }

        if(!$json) {
            $result = $this->TermService->saveTerm($post_data);

            if(empty($result['error'])){

                $json['product_id'] = $result['data']['id'];
                $json['success'] = $this->lang->text_success;
                $json['replace_url'] = route('lang.admin.common.terms.form', $result['data']['id']); // only change url
                // $json['redirect'] = route('lang.admin.common.terms.form', $result['data']['id']); // redirect to new page
                
            }else{
                if(config('app.debug')){
                    $json['error'] = $result['error'];
                }else{
                    $json['error'] = $this->lang->text_fail;
                }
            }
        }

        return response(json_encode($json))->header('Content-Type','application/json');
    }


    public function delete()
    {
        $post_data = $this->request->post();

		$json = [];

        // Permission
        // if($this->acting_username !== 'admin'){
        //     $json['error'] = $this->lang->error_permission;
        // }

        // Selected
		if (isset($post_data['selected'])) {
			$selected = $post_data['selected'];
		} else {
			$selected = [];
		}

		if (!$json) {

			foreach ($selected as $id) {
				$result = $this->TermService->deleteTerm($id);

                if(!empty($result['error'])){
                    if(config('app.debug')){
                        $json['error'] = $result['error'];
                    }else{
                        $json['error'] = $this->lang->text_fail;
                    }

                    break;
                }
			}
		}
        
        if(empty($json['error'] )){
            $json['success'] = $this->lang->text_success;
        }

        return response(json_encode($json))->header('Content-Type','application/json');
    }


    public function autocomplete ()
    {

        $query_data = $this->request->query();

        // Prepare query_data for records
        $filter_data = UrlHelper::getUrlQueries($query_data);

        $rows = $this->TermService->getGroupedPath($filter_data,1);

        $json = [];

        foreach ($rows as $row) {
            $json[] = array(
                'value' => $row['id'] ?? '',
                'label' => $row['name'] ?? '',
                'term_path_id' => $row['id'] ?? '',
                'name' => $row['name'] ?? '',
                'group_id' => $row['group_id'] ?? '',
            );
        }

        return response(json_encode($json))->header('Content-Type','application/json');
    }
}
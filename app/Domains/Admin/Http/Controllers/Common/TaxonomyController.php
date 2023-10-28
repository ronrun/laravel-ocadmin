<?php

namespace App\Domains\Admin\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Domains\Admin\Http\Controllers\BackendController;
use App\Http\Controllers\Controller;
use App\Domains\Admin\Services\Common\TaxonomyService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Helpers\Classes\UrlHelper;

class TaxonomyController extends BackendController
{
    protected $lang;
    
    public function __construct(private Request $request, private TaxonomyService $TaxonomyService, )
    {
        parent::__construct();
        $this->getLang(['ocadmin/common/common','ocadmin/common/taxonomy']);
    }

    public function index()
    {
        $data['lang'] = $this->lang;

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];

        //echo '<pre>', print_r($this->lang, 1), "</pre>"; exit;
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
            'href' => route('lang.admin.common.taxonomies.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $data['add_url'] = route('lang.admin.common.taxonomies.form');
        $data['list_url'] = route('lang.admin.common.taxonomies.list');
        $data['delete_url'] = route('lang.admin.common.taxonomies.delete');
        
        $data['list'] = $this->getList();

        return view('ocadmin.common.taxonomy', $data);
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
        $taxonomies = $this->TaxonomyService->getTaxonomies($query_data);

        if(!empty($taxonomies)){
            foreach ($taxonomies as $row) {
                $row->edit_url = route('lang.admin.common.taxonomies.form', array_merge([$row->id], $query_data));
            }
        }

        $data['save_url'] = route('lang.admin.common.taxonomies.save');
        $data['back_url'] = route('lang.admin.common.taxonomies.index', $queries);
        $data['list_url'] = route('lang.admin.common.taxonomies.list');

        $taxonomies = $taxonomies->withPath(route('lang.admin.common.taxonomies.list'))->appends($query_data);
        
        $data['taxonomies'] = $taxonomies;

        // Prepare links for list table's header
        if($query_data['order'] == 'ASC'){
            $order = 'DESC';
        }else{
            $order = 'ASC';
        }
        
        $data['sort'] = strtolower($query_data['sort']);
        $data['order'] = strtolower($order);

        //$query_data = $this->unsetUrlQueryData($query_data,['whereIn']);

        $url = '';

        foreach($query_data as $key => $value){
            $url .= "&$key=$value";
        }


        // link of table header for sorting        
        $route = route('lang.admin.common.taxonomies.list');

        $data['sort_id'] = $route . "?sort=id&order=$order" .$url;
        $data['sort_code'] = $route . "?sort=code&order=$order" .$url;
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_taxonomy'] = $route . "?sort=taxonomy&order=$order" .$url;
        
        return view('ocadmin.common.taxonomy_list', $data);
    }

    public function form($taxonomy_id = null)
    {
        // Language
        $this->lang->text_form = empty($taxonomy_id) ? $this->lang->text_add : $this->lang->text_edit;

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
            'href' => route('lang.admin.common.taxonomies.index'),
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

        $data['save_url'] = route('lang.admin.common.taxonomies.save');
        $data['back_url'] = route('lang.admin.common.taxonomies.index', $queries);

        $data['supportedLocales'] = LaravelLocalization::getLocalesOrder();

        // Get Record
        $taxonomy = $this->TaxonomyService->findIdOrFailOrNew(id:$taxonomy_id);

        $data['taxonomy']  = $taxonomy;
        
        $data['taxonomy_id'] = $taxonomy->id ?? null;

        $data['supportedLocales'] = LaravelLocalization::getLocalesOrder();

        if(!empty($taxonomy->id)){
            $data['translations'] = $taxonomy->sortedTranslations();
        }
        
        return view('ocadmin.common.taxonomy_form', $data);
    }

    public function save()
    {
        $post_data = $this->request->post();
        $queryData = $this->request->query();

        $json = [];

        // validator

        if(!$json) {
            $result = $this->TaxonomyService->saveTaxonomy($post_data);

            if(empty($result['error'])){

                $json['product_id'] = $result['data']['id'];
                $json['success'] = $this->lang->text_success;
                $json['replace_url'] = route('lang.admin.catalog.products.form', $result['data']['id']);
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
				$result = $this->TaxonomyService->deleteTaxonomy($id);

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


    public function autocomplete()
    {
        $data['lang'] = $this->lang;

        $query_data = $this->request->query();

        // Prepare query_data for records
        $filter_data = UrlHelper::getUrlQueries($query_data);

        if(!empty($filter_data['equal_code'])){
            if (strpos($filter_data['equal_code'], ',') !== false) {
                $arr = explode(',', $filter_data['equal_code']);
                $filter_data['whereIn'] = ['code' => $arr];
                unset($filter_data['equal_code']);
            }
        }

        $rows = $this->TaxonomyService->getTaxonomies($filter_data);

        $json = [];

        foreach ($rows as $row) {
            $json[] = array(
                'label' => $row->code . ' ' . $row->name,
                'value' => $row->id,
                'id' => $row->id,
                'code' => $row->code,
                'name' => $row->name,
            );
        }

        return response(json_encode($json))->header('Content-Type','application/json');
    }
}
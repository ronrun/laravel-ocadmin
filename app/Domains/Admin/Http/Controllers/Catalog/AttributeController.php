<?php

namespace App\Domains\Admin\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\TranslationLibrary;
use App\Domains\Admin\Services\Catalog\AttributeService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AttributeController extends Controller
{
    private $lang;
    private $request;
    private $AttributeService;

    public function __construct(Request $request, AttributeService $AttributeService)
    {
        $this->request = $request;
        $this->AttributeService = $AttributeService;
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/catalog/attribute']);
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
            'text' => $this->lang->text_attributes,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.catalog.attributes.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $data['add_url'] = route('lang.admin.catalog.attributes.form');
        $data['list_url'] = route('lang.admin.catalog.attributes.list');
        
        $data['list'] = $this->getList();

        return view('ocadmin.catalog.attribute', $data);
    }


    public function list()
    {
        return $this->getList();
    }


    public function getList()
    {
        $data['lang'] = $this->lang;

        // Prepare link for action
        $queries = [];

        if(!empty($this->request->query('page'))){
            $page = $queries['page'] = $this->request->input('page');
        }else{
            $page = $queries['page'] = 1;
        }

        if(!empty($this->request->query('sort'))){
            $sort = $queries['sort'] = $this->request->input('sort');
        }else{
            $sort = $queries['sort'] = 'id';
        }

        if(!empty($this->request->query('order'))){
            $order = $queries['order'] = $this->request->query('order');
        }else{
            $order = $queries['order'] = 'DESC';
        }

        if(!empty($this->request->query('limit'))){
            $limit = $queries['limit'] = $this->request->query('limit');
        }

        foreach($this->request->all() as $key => $value){
            if(strpos($key, 'filter_') !== false){
                $queries[$key] = $value;
            }
        }

        // Rows
        $records = $this->AttributeService->getCategories($queries,1);

        if(!empty($records)){
            foreach ($records as $row) {
                $row->edit_url = route('lang.admin.catalog.attributes.form', array_merge([$row->id], $queries));
            }
        }

        $data['records'] = $records->withPath(route('lang.admin.catalog.attributes.list'))->appends($queries); 

        // Prepare links for list table's header
        if($order == 'ASC'){
            $order = 'DESC';
        }else{
            $order = 'ASC';
        }

        $data['sort'] = strtolower($sort);
        $data['order'] = strtolower($order);

        unset($queries['sort']);
        unset($queries['order']);

        $url = '';

        foreach($queries as $key => $value){
            $url .= "&$key=$value";
        }

        //link of table header for sorting
        $route = route('lang.admin.catalog.attributes.list');
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_date_added'] = $route . "?sort=created_at&order=$order" .$url;

        $data['list_url'] = route('lang.admin.catalog.attributes.list');

        return view('ocadmin.catalog.attribute_list', $data);
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
            'text' => $this->lang->text_attributes,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.catalog.attributes.index'),
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

        $data['save_url'] = route('lang.admin.catalog.attributes.save');
        $data['back_url'] = route('lang.admin.catalog.attributes.index', $queries);

        $data['supportedLocales'] = LaravelLocalization::getLocalesOrder();

        // Get Record
        $term = $this->AttributeService->findOrFailOrNew(id:$term_id);

        $data['term']  = $term;
        
        $data['term_id'] = $term_id ?? null;
        
        $data['translations'] = $term->sortedTranslations();
        
        return view('ocadmin.catalog.attribute_form', $data);
    }


    public function save()
    {
        $postData = $this->request->post();

        $json = [];

        // Validate
        foreach ($postData['translations'] as $locale => $translation) {
            if(empty($translation['name']) || mb_strlen($translation['name']) < 1){
                $json['error']['name-' . $locale] = $this->lang->error_name;
            }
        }  


        // Default error warning   
        if(isset($json['error']) && !isset($json['error']['warning'])) {
            $json['error']['warning'] = $this->lang->error_warning;
        }

        if(!$json) {
            $result = $this->AttributeService->save($postData);

            if(empty($result['error'])){
                $json['term_id'] = $result['term_id'];
                $json['success'] = $this->lang->text_success;
                $json['replace_url'] = route('lang.admin.catalog.attributes.form', $result['term_id']);
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


}
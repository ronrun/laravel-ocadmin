<?php

namespace App\Domains\Admin\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\TranslationLibrary;
use App\Domains\Admin\Services\Catalog\FilterService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FilterController extends Controller
{
    private $lang;
    private $request;
    private $FilterService;

    public function __construct(Request $request, FilterService $FilterService)
    {
        $this->request = $request;
        $this->FilterService = $FilterService;
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/catalog/filter']);
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
            'text' => $this->lang->text_categories,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.catalog.categories.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $data['add_url'] = route('lang.admin.catalog.categories.form');
        $data['list_url'] = route('lang.admin.catalog.categories.list');
        
        $data['list'] = $this->getList();

        return view('ocadmin.catalog.category', $data);
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
        $records = $this->FilterService->getCategories($queries,1);

        if(!empty($records)){
            foreach ($records as $row) {
                $row->edit_url = route('lang.admin.catalog.categories.form', array_merge([$row->id], $queries));
            }
        }

        $data['records'] = $records->withPath(route('lang.admin.catalog.categories.list'))->appends($queries,1); 

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
        $route = route('lang.admin.catalog.categories.list');
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_date_added'] = $route . "?sort=created_at&order=$order" .$url;

        $data['list_url'] = route('lang.admin.catalog.categories.list');

        return view('ocadmin.catalog.category_list', $data);
    }


    public function form($category_id = null)
    {
        // Language
        $this->lang->text_form = empty($category_id) ? $this->lang->text_add : $this->lang->text_edit;

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
            'href' => route('lang.admin.catalog.categories.index'),
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

        $data['save_url'] = route('lang.admin.catalog.categories.save');
        $data['back_url'] = route('lang.admin.catalog.categories.index', $queries);

        $data['supportedLocales'] = LaravelLocalization::getLocalesOrder();

        // Get Record
        $category = $this->FilterService->findOrFailOrNew(id:$category_id);

        $data['category']  = $category;
        
        $data['category_id'] = $category_id ?? null;
        
        $data['translations'] = $category->sortedTranslations();
        
        return view('ocadmin.catalog.category_form', $data);
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
            
            if(empty($translation['slug']) || mb_strlen($translation['slug']) < 1){
                $json['error']['slug-' . $locale] = $this->lang->error_slug;
            }
        }  


        // Default error warning   
        if(isset($json['error']) && !isset($json['error']['warning'])) {
            $json['error']['warning'] = $this->lang->error_warning;
        }

        if(!$json) {
            $result = $this->FilterService->save($postData);

            if(empty($result['error'])){
                $json['category_id'] = $result['category_id'];
                $json['success'] = $this->lang->text_success;
                $json['replace_url'] = route('lang.admin.catalog.categories.form', $result['category_id']);
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
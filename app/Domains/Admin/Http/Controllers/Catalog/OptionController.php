<?php

namespace App\Domains\Admin\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\TranslationLibrary;
use App\Domains\Admin\Services\Catalog\OptionService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class OptionController extends Controller
{
    private $lang;
    private $request;
    private $OptionService;

    public function __construct(Request $request, OptionService $OptionService)
    {
        $this->request = $request;
        $this->OptionService = $OptionService;
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/catalog/option']);
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
            'href' => route('lang.admin.catalog.options.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $data['add_url'] = route('lang.admin.catalog.options.form');
        $data['list_url'] = route('lang.admin.catalog.options.list');
        
        $data['list'] = $this->getList();

        return view('ocadmin.catalog.option', $data);
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
        $options = $this->OptionService->getOptions($queries);

        if(!empty($options)){
            foreach ($options as $row) {
                $row->edit_url = route('lang.admin.catalog.options.form', array_merge([$row->id], $queries));
            }
        }

        $data['options'] = $options->withPath(route('lang.admin.catalog.options.list'))->appends($queries,1); 

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
        $route = route('lang.admin.catalog.options.list');
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_date_added'] = $route . "?sort=created_at&order=$order" .$url;

        $data['list_url'] = route('lang.admin.catalog.options.list');

        return view('ocadmin.catalog.option_list', $data);
    }


    public function form($option_id = null)
    {
        // Language
        $this->lang->text_form = empty($option_id) ? $this->lang->text_add : $this->lang->text_edit;

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
            'href' => route('lang.admin.catalog.options.index'),
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

        $data['save_url'] = route('lang.admin.catalog.options.save');
        $data['back_url'] = route('lang.admin.catalog.options.index', $queries);

        $data['supportedLocales'] = LaravelLocalization::getLocalesOrder();

        // Get Record
        $option = $this->OptionService->findOrFailOrNew(id:$option_id);

        $data['option']  = $option;
        $data['option_id'] = $option_id ?? null;        
        $data['translations'] = $option->sortedTranslations();

        //$option_values = $this->OptionService->getOptionValues(option_id:$option->id);
        //echo '<pre>option_values ', print_r($option->option_values->toArray(), 1), "</pre>"; exit;
        $option_values = $option->option_values;

        $data['option_values']  = $option_values;
        
        return view('ocadmin.catalog.option_form', $data);
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
            $result = $this->OptionService->save($postData);

            if(empty($result['error'])){
                $json['option_id'] = $result['option_id'];
                $json['success'] = $this->lang->text_success;
                $json['replace_url'] = route('lang.admin.catalog.options.form', $result['option_id']);
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
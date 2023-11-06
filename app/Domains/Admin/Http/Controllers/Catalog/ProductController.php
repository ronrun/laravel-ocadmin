<?php

namespace App\Domains\Admin\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\TranslationLibrary;
use App\Domains\Admin\Services\Catalog\ProductService;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductController extends Controller
{
    protected $lang;

    public function __construct(private Request $request, private ProductService $ProductService)
    {
        $this->request = $request;
        $this->ProductService = $ProductService;
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/catalog/product']);
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
            'text' => $this->lang->text_products,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.catalog.products.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $data['add_url'] = route('lang.admin.catalog.products.form');
        $data['list_url'] = route('lang.admin.catalog.products.list');
        
        $data['list'] = $this->getList();

        return view('ocadmin.catalog.product', $data);
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

        $filter_data = $queries;

        // Rows
        $filter_data['select'] = ['id', 'model'];
        $rows = $this->ProductService->getProducts($filter_data);
        echo '<pre>', print_r($rows, 1), "</pre>"; exit;
        if(!empty($rows)){
            foreach ($rows as $row) {
                $row->edit_url = route('lang.admin.catalog.products.form', array_merge([$row->id], $queries));
            }
        }

        $data['rows'] = $rows->withPath(route('lang.admin.catalog.products.list'))->appends($queries); 

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
        $route = route('lang.admin.catalog.products.list');
        
        $data['sort_id'] = $route . "?sort=id&order=$order" .$url;
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_date_added'] = $route . "?sort=created_at&order=$order" .$url;

        $data['list_url'] = route('lang.admin.catalog.products.list');

        return view('ocadmin.catalog.product_list', $data);
    }


    public function form($product_id = null)
    {
        // Language
        $this->lang->text_form = empty($product_id) ? $this->lang->text_add : $this->lang->text_edit;

        $data['lang'] = $this->lang;

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_products,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.catalog.products.index'),
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

        $data['save_url'] = route('lang.admin.catalog.products.save');
        $data['back_url'] = route('lang.admin.catalog.products.index', $queries);
        $data['supportedLocales'] = LaravelLocalization::getLocalesOrder();

        // Get Record
        $product = $this->ProductService->findIdOrFailOrNew(id:$product_id);

        $data['product']  = $product;
        
        $data['product_id'] = $product_id ?? null;
        
        $data['translations'] = $product->sortedTranslations();

        return view('ocadmin.catalog.product_form', $data);
    }


    public function save()
    {
        $post_data = $this->request->post();
        $queryData = $this->request->query();

        $json = [];

        // validator

        if(!$json) {
            $result = $this->ProductService->saveProduct($post_data);

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
}
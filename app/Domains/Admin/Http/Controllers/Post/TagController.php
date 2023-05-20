<?php

namespace App\Domains\Admin\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\TranslationLibrary;
use App\Domains\Admin\Services\Post\TagService;
use LaravelLocalization;

class TagController extends Controller
{
    private $lang;
    private $request;
    private $TagService;

    public function __construct(Request $request, TagService $TagService)
    {
        $this->request = $request;
        $this->TagService = $TagService;
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/common/term','ocadmin/post/tag']);
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
            'text' => $this->lang->text_post,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.post.tags.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $data['addUrl'] = route('lang.admin.post.tags.form');
        $data['listUrl'] = route('lang.admin.post.tags.list');

        $data['list'] = $this->getList();

        return view('ocadmin.post.tag', $data);
    }


    public function list()
    {
        $data['lang'] = $this->lang;
        $data['form_action'] = route('lang.admin.post.tags.list');

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
        $users = $this->TagService->getTags($queries);

        if(!empty($users)){
            foreach ($users as $row) {
                $row->edit_url = route('lang.admin.post.tags.form', array_merge([$row->id], $queries));
            }
        }

        $data['records'] = $users->withPath(route('lang.admin.post.tags.list'))->appends($queries); 

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
        $route = route('lang.admin.post.tags.list');
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_date_added'] = $route . "?sort=created_at&order=$order" .$url;

        $data['listUrl'] = route('lang.admin.post.tags.list');

        return view('ocadmin.post.tag_list', $data);
    }


    public function form($tag_id = null)
    {
        // Language
        $this->lang->text_form = empty($tag_id) ? $this->lang->text_add : $this->lang->text_edit;

        $data['lang'] = $this->lang;

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_post,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.post.tags.index'),
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

        $data['save'] = route('lang.admin.post.tags.save');
        $data['back'] = route('lang.admin.post.tags.index', $queries);
        $data['supportedLocales'] = LaravelLocalization::getLocalesOrder();

        // Get Record
        $tag = $this->TagService->findOrFailOrNew(id:$tag_id);

        $data['tag']  = $tag;
        
        $data['tag_id'] = $tag_id ?? null;
        
        $data['tag_translations'] = $tag->sortedTranslations();
        
        return view('ocadmin.post.tag_form', $data);
    }


    public function save()
    {
        $postData = $this->request->post();
        $queryData = $this->request->query();

        $json = [];

        // validator

        if(!$json) {
            $result = $this->TagService->save($postData);

            if(empty($result['error'])){
                $json['tag_id'] = $result['data']['record_id'];
                $json['success'] = $this->lang->text_success;
                $json['replaceUrl'] = route('lang.admin.post.tags.form', $result['data']['record_id']);
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
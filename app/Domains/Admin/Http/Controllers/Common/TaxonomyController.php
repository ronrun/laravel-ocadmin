<?php

namespace App\Domains\Admin\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Domains\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Domains\Admin\Services\Common\TaxonomyService;
use App\Repositories\Sysdata\LanguageRepository;

class TaxonomyController extends AdminController
{
    public function __construct(protected Request $request
        , private TaxonomyService $TaxonomyService
        , private LanguageRepository $languageRepository)
    {
        parent::__construct();
        
        $this->getLang(['admin/common/common','admin/common/taxonomy']);
    }

    public function index()
    {
        $data['lang'] = $this->lang;

        $query_data = $this->getQueries($this->request->query());

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_permission,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.system.term.taxonomies.index'),
        ];
        $data['breadcumbs'] = (object)$breadcumbs;

        $data['list'] = $this->getList();
        
        $data['list_url']   = route('lang.admin.system.term.taxonomies.list');
        $data['add_url']    = route('lang.admin.system.term.taxonomies.form');
        $data['delete_url'] = route('lang.admin.system.term.taxonomies.destroy');
        
        //Filters
        $data['filter_keyname'] = 123;
        $data['filter_phone'] = $query_data['filter_phone'] ?? '';
        $data['equal_is_admin'] = $query_data['equal_is_admin'] ?? 1;
        $data['equal_is_active'] = $query_data['equal_is_active'] ?? 1;

        return view('admin.common.taxonomy', $data);
    }

    public function list()
    {
        $data['lang'] = $this->lang;

        $data['form_action'] = route('lang.admin.system.term.taxonomies.list');

        return $this->getList();
    }

    /**
     * Show the list table.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    private function getList()
    {
        $data['lang'] = $this->lang;

        // Prepare queries for records
        $query_data = $this->getQueries($this->request->query());

        if(isset($query_data['equal_is_admin']) && $query_data['equal_is_admin'] == 0){
            $query_data['whereDoesntHave']['metas'] = ['is_admin' => 1];
            unset($query_data['equal_is_admin']);
        }


        // Rows
        $taxonomies = $this->TaxonomyService->getTaxonomies($query_data);
        
        if(!empty($taxonomies)){
            foreach ($taxonomies as $row) {
                $row->edit_url = route('lang.admin.system.term.taxonomies.form', array_merge([$row->id], $query_data));
            }
        }

        $data['taxonomies'] = $taxonomies->withPath(route('lang.admin.system.term.taxonomies.list'))->appends($query_data);


        // Prepare links for list table's header
        if($query_data['order'] == 'ASC'){
            $order = 'DESC';
        }else{
            $order = 'ASC';
        }
        
        $data['sort'] = strtolower($query_data['sort']);
        $data['order'] = strtolower($order);

        unset($query_data['sort']);
        unset($query_data['order']);
        unset($query_data['with']);
        unset($query_data['whereDoesntHave']);

        $url = '';

        foreach($query_data as $key => $value){
            $url .= "&$key=$value";
        }

        //link of table header for sorting
        $route = route('lang.admin.system.term.taxonomies.list');

        $data['sort_code'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_created_at'] = $route . "?sort=created_at&order=$order" .$url;
        
        $data['list_url'] = route('lang.admin.system.term.taxonomies.list');
        $data['add_url']    = route('lang.admin.system.term.taxonomies.form');

        return view('admin.common.taxonomy_list', $data);
    }


    public function form($taxonomy_id = null)
    {
        $data['lang'] = $this->lang;

        // Languages
        $data['languages'] = $this->languageRepository->newModel()->active()->get();

        $this->lang->text_form = empty($taxonomy_id) ? $this->lang->trans('text_add') : $this->lang->trans('text_edit');

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_user,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.system.term.taxonomies.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;


        // Prepare link for save, back
        $queries = $this->getQueries($this->request->query());

        $data['save_url'] = route('lang.admin.system.term.taxonomies.save');
        $data['back_url'] = route('lang.admin.system.term.taxonomies.index', $queries);


        // Get Record
        $taxonomy = null;

        $result = $this->TaxonomyService->findIdOrFailOrNew($taxonomy_id);

        if(empty($result['error']) && !empty($result['data'])){
            $taxonomy = $result['data'];
        }else{
            return response(json_encode(['error' => $result['error']]))->header('Content-Type','application/json');
        }
        unset($result);

        $data['translations'] = $taxonomy->translations();

        $data['taxonomy'] = $taxonomy;

        if(!empty($data['taxonomy']) && $taxonomy_id == $taxonomy->id){
            $data['taxonomy_id'] = $taxonomy_id;
        }else{
            $data['taxonomy_id'] = null;
        }

        return view('admin.common.taxonomy_form', $data);
        
    }


    public function save()
    {
        $post_data = $this->request->post();

        if($this->request->query('taxonomy_id')){
            $post_data['taxonomy_id'] = $this->request->query('taxonomy_id');
        }

        // Check user
        $json = $this->validator($post_data);

        if(!$json) {
            $result = $this->TaxonomyService->save($post_data);
            if(empty($result['error'])){
                $json = [
                    'success' => $this->lang->text_success,
                    'taxonomy_id' => $result['data']['taxonomy_id'],
                    'redirectUrl' => route('lang.admin.system.term.taxonomies.form', $result['data']['taxonomy_id']),
                    //'redirect' => route('lang.admin.system.term.taxonomies.form', $result['data']['taxonomy_id']),
                    //'redirect' => route('lang.admin.system.term.taxonomies.form', $result['data']['taxonomy_id']),
                    
                ];

            }else{
                $taxonomy_id = auth()->user()->id;
                if($taxonomy_id == 1){
                    $json['error'] = $result['error'];
                }else{
                    $json['error'] = $this->lang->text_fail;
                }
            }
        }

        return response(json_encode($json))->header('Content-Type','application/json');
    }

    public function destroy()
    {
        $post_data = $this->request->post();

        $json = [];

        if (isset($post_data['selected'])) {
            $selected = $post_data['selected'];
        } else {
            $selected = [];
        }

        // Permission
        //暫時用 admin 來判斷是否有權限刪除使用者。
        $user = auth()->user();

        if($user->username !== 'admin'){
            $json['error'] = $this->lang->error_permission;
        }
        
		if (!$json) {
            $result = $this->TaxonomyService->destroy($selected);

            if(empty($result['error'])){
                $json['success'] = $this->lang->text_success;
            }else{
                if(config('app.debug') || auth()->user()->username == 'admin'){
                    $json['error'] = $result['error'];
                }else{
                    $json['error'] = $this->lang->text_fail;
                }
            }
		}

        return response(json_encode($json))->header('Content-Type','application/json');
    }

    public function validator($data)
    {

    }
    
}
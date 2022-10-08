<?php
 
namespace App\Domains\Ocadmin\ViewComposers;
 
use Illuminate\View\View;
use Lang;

class ColumnLeftComposer
{ 
    /**
     * Create a new sidebar composer.
     *
     * @param  ...
     * @return void
     */
    //public function __construct(UserRepository $users)
    public function __construct()
    {
        $this->authUser = auth()->user();
        $this->simUser = auth()->user();
        $this->base = config('config.admin_url');
        
    }
 
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Language
        $lang = (object)[];
        foreach (Lang::get('ocadmin/common/column_left') as $key => $value) {
            $lang->$key = $value;
        }
        $this->lang = $lang;
        
        $view->with('authUser', $this->authUser);
        $view->with('simUser', $this->simUser);
        
        $leftMenus = $this->getColumnLeft();

        $view->with('navigation', $this->lang->text_navigation);
        $view->with('menus', $leftMenus);
    }

    public function getColumnLeft()
    {
        $menus[] = [
            'id'       => 'menu-dashboard',
            'icon'	   => 'fas fa-home',
            'name'	   => $this->lang->text_dashboard,
            'href'     => route('lang.admin.dashboard'),
            'children' => []
        ];

        // Catalog
        //$catalog = [];
        /*
        // Catalog / Category
        if(1) {
            $catalog[] = [
                'name'	   => 'Categorie',
                'icon'	   => '',
                'href'     => route('lang.admin.catalog.categories.index'),
                'children' => []
            ];
        }

        // Catalog / Product
        if(1) {
            $catalog[] = [
                'name'	   => 'Products',
                'icon'	   => '',
                'href'     => route('lang.admin.catalog.products.index'),
                'children' => []
            ];
        }
        */


        // Catalog / Update Meta
        $meta = [];

        if(0) {
            $meta[] = [
                'name'	   => $this->lang->products,
                'icon'	   => ' ',
                'href'     => route('lang.admin.catalog.products.showMetaForm'),
                'children' => []
            ];
        }

        if(!empty($meta)) {
            $catalog[] = [
                'name'	   => 'Update Meta',
                'icon'	   => ' ',
                'href'     => '',
                'children' => $meta
            ];
        }

        // add to Menus
        if(!empty($catalog)) {
            $menus[] = [
                'id'       => 'menu-catalog',
                'icon'	   => 'fas fa-tag',
                'name'	   => $this->lang->catalog,
                'href'     => '',
                'children' => $catalog
            ];
        }

        // if(1) {
        //     $sales[] = [
        //         'name'	   => $this->lang->cto,
        //         'icon'	   => '',
        //         'href'     => route('lang.admin.sales.cto.index'),
        //         'children' => []
        //     ];
        // }

        // Members
        $member = [];

        if(1) {
            $member[] = [
                'name'	   => $this->lang->text_individual,
                'icon'	   => '',
                'href'     => route('lang.admin.member.members.index'),
                'children' => []
            ];
        }

        if(1) {
            $member[] = [
                'name'	   => $this->lang->text_organization,
                'icon'	   => '',
                'href'     => route('lang.admin.member.members.index'),
                'children' => []
            ];
        }

        // add to Menus
        if(!empty($member)) {
            $menus[] = [
                'id'       => 'menu-members',
                'icon'	   => 'fas fa-user',
                'name'	   => $this->lang->text_member,
                'href'     => '',
                'children' => $member
            ];
        }

        /**
         * System
         */
        // Setting
        if(1) {
            $system[] = [
                'name'	   => $this->lang->text_setting,
                'icon'	   => '',
                'href'     => route('lang.admin.system.setting.stores.index'),
                'children' => []
            ];
        }

        // System / Database
        if(!empty($this->authUser['username']) && $this->authUser['username'] == 'ronlee') {
            $database[] = [
                'name'	   => 'Import',
                'icon'	   => ' ',
                'href'     => route('lang.admin.system.database.import.index'),
                'children' => []
            ];
        }
        
        if(isset($database)) {
            $system[] = [
                'name'	   => $this->lang->text_database,
                'icon'	   => ' ',
                'href'     => '',
                'children' => $database
            ];
        }

        if(!empty($system)) {
            $menus[] = [
                'id'       => 'menu-system',
                'icon'	   => 'fas fa-cog',
                'name'	   => $this->lang->text_system,
                'href'     => '',
                'children' => $system
            ];
        }
        
        return $menus;
    }
}
<?php
 
namespace App\Domains\Ocadmin\ViewComposers;
 
use Illuminate\View\View;
use Lang;

class LayoutComposer
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
        $view->with('base', $this->base);
        
        $leftMenus = $this->getColumnLeft();
        //$leftMenus = [];
        $view->with('navigation', $this->lang->navigation);
        $view->with('menus', $leftMenus);
    }

    public function getColumnLeft()
    {
        $menus[] = [
            'id'       => 'menu-dashboard',
            'icon'	   => 'fas fa-home',
            'name'	   => $this->lang->dashboard,
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

        // Sales / Orders
        if(0) {
            $sales[] = [
                'name'	   => $this->lang->orders,
                'icon'	   => '',
                'href'     => route('lang.admin.sales.orders.index'),
                'children' => []
            ];
        }

        if(0) {
            $sales[] = [
                'name'	   => $this->lang->cto,
                'icon'	   => '',
                'href'     => route('lang.admin.sales.cto.index'),
                'children' => []
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

        // System / User (Users, Roles, Permissions)
        $dr = [];

        // System / User / Users
        if(0) {
            $dr[] = [
                'name'	   => 'Project',
                'icon'	   => ' ',
                'href'     => route('lang.admin.sales.dr.project.index'),
                'children' => []
            ];
        }

        // System / User / Roles
        if(0) {
            $dr[] = [
                'name'	   => 'Tracking',
                'icon'	   => ' ',
                'href'     => route('lang.admin.sales.dr.tracking.index'),
                'children' => []
            ];
        }

        if($dr) {
            $sales[] = [
                'name'	   => 'DR',
                'icon'	   => ' ',
                'href'     => '',
                'children' => $dr
            ];
        }

        // add to Menus
        if(!empty($sales)) {
            $menus[] = [
                'id'       => 'menu-sales',
                'icon'	   => 'fas fa-tag',
                'name'	   => $this->lang->sales,
                'href'     => '',
                'children' => $sales
            ];
        }

        // Members
        $member = [];

        // Members / Members
        if(0) {
            $member[] = [
                'name'	   => $this->lang->members,
                'icon'	   => '',
                'href'     => route('lang.admin.member.members.index'),
                'children' => []
            ];
        }

        // add to Menus
        if(!empty($member)) {
            $menus[] = [
                'id'       => 'menu-members',
                'icon'	   => 'fas fa-tag',
                'name'	   => $this->lang->members,
                'href'     => '',
                'children' => $member
            ];
        }

        // Tools
        $tools = [];

        // Tools / Setting
        if(0) {
            $tools[] = [
                'name'	   => 'Translations',
                'icon'	   => '',
                'href'     => route('lang.admin.tools.trans_from_opencart'),
                'children' => []
            ];
        }

        // add to Menus
        if(!empty($tools)) {
            $menus[] = [
                'id'       => 'menu-tools',
                'icon'	   => 'fas fa-tag',
                'name'	   => 'Tools',
                'href'     => '',
                'children' => $tools
            ];
        }

        /**
         * System
         */
        // Setting
        if(1) {
            $system[] = [
                'name'	   => $this->lang->settings,
                'icon'	   => ' ',
                'href'     => route('lang.admin.system.settings.index'),
                'children' => []
            ];
        }


        // System / User (Users, Roles, Permissions)
        $user = [];

        // System / User / Users
        if(0) {
            $user[] = [
                'name'	   => 'Users',
                //$this->lang->users,
                'icon'	   => ' ',
                'href'     => route('lang.admin.system.user.users.index'),
                'children' => []
            ];
        }

        // System / User / Roles
        if(0) {
            $user[] = [
                'name'	   => 'Roles',
                'icon'	   => ' ',
                'href'     => route('lang.admin.system.user.roles.index'),
                'children' => []
            ];
        }

        if(!empty($user)) {
            $system[] = [
                'name'	   => $this->lang->users,
                'icon'	   => ' ',
                'href'     => '',
                'children' => $user
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
                'name'	   => $this->lang->database,
                'icon'	   => ' ',
                'href'     => '',
                'children' => $database
            ];
        }

        if(!empty($system)) {
            $menus[] = [
                'id'       => 'menu-system',
                'icon'	   => 'fas fa-tag',
                'name'	   => $this->lang->system,
                'href'     => '',
                'children' => $system
            ];
        }
        
        return $menus;
    }
}
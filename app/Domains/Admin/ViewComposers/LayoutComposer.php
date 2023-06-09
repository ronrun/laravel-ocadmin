<?php
 
namespace App\Domains\Admin\ViewComposers;
 
use Illuminate\View\View;
use App\Libraries\TranslationLibrary;
use Lang;

class LayoutComposer
{ 
    protected $base;
    protected $lang;

    /**
     * Create a new sidebar composer.
     *
     * @param  ...
     * @return void
     */
    //public function __construct(UserRepository $users)
    public function __construct()
    {
        $this->base = config('app.admin_url');

        // Translations
        $groups = [
            'ocadmin/common/common',
            'ocadmin/common/column_left',
            'ocadmin/setting/setting',
        ];
        $this->lang = (new TranslationLibrary())->getTranslations($groups);
    }
 
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {        
        $view->with('authUser', auth()->user());
        $view->with('base', $this->base);
        
        $leftMenus = $this->getColumnLeft();
        //$leftMenus = [];
        $view->with('navigation', $this->lang->text_navigation);
        $view->with('menus', $leftMenus);
        $view->with('appName', env('APP_NAME'));
        
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

        /**
         * Post
         */
        // L2
        if(1) {
            $post[] = [
                'name'	   => $this->lang->text_tags,
                'icon'	   => '',
                'href'     => route('lang.admin.post.tags.index'),
                'children' => []
            ];
        }

        if(1) {
            $post[] = [
                'name'	   => $this->lang->text_categories,
                'icon'	   => '',
                'href'     => route('lang.admin.post.categories.index'),
                'children' => []
            ];
        }
        
        if(1) {
            $post[] = [
                'name'	   => $this->lang->text_posts,
                'icon'	   => '',
                'href'     => route('lang.admin.post.posts.index'),
                'children' => []
            ];
        }
        
        if(!empty($post)) {
            $menus[] = [
                'id'       => 'menu-post',
                'icon'	   => 'fas fa-cog',
                'name'	   => 'Post',
                'href'     => '',
                'children' => $post
            ];
        }

        /**
         * Catalog
         */
        // L2
        if(1) {
            $product[] = [
                'name'	   => $this->lang->text_catalog_tags,
                'icon'	   => '',
                'href'     => route('lang.admin.catalog.tags.index'),
                'children' => []
            ];
        }

        if(1) {
            $product[] = [
                'name'	   => $this->lang->text_catalog_categories,
                'icon'	   => '',
                'href'     => route('lang.admin.catalog.categories.index'),
                'children' => []
            ];
        }
        
        if(1) {
            $product[] = [
                'name'	   => $this->lang->text_catalog_products,
                'icon'	   => '',
                'href'     => route('lang.admin.catalog.products.index'),
                'children' => []
            ];
        }
        
        if(!empty($product)) {
            $menus[] = [
                'id'       => 'menu-product',
                'icon'	   => 'fas fa-cog',
                'name'	   => 'Catalog',
                'href'     => '',
                'children' => $product
            ];
        }

        /**
         * System
         */

        // 
        $admin = [];

        if (1) {
            $admin[] = [
                'name'	   => 'Users', // user/users
                'href'     => route('lang.admin.system.admin.users.index'),
                'icon'	   => ' ',
            ];
        }

        if (1) {
            $admin[] = [
                'name'	   => 'Permissions', // user/permissions
                'href'     => route('lang.admin.system.admin.permissions.index'),
                'icon'	   => ' ',
            ];
        }

        if (1) {
            $admin[] = [
                'name'	   => 'Roles',  // user/roles
                'href'     => route('lang.admin.system.admin.roles.index'),
                'icon'	   => ' ',
            ];
        }

        if ($admin) {
            $system[] = [
                'name'	   => 'Admins', // user
                'icon'	   => ' ',
                'children' => $admin
            ];
        }



        // System Maintenance
        $maintenance = [];

        // System Maintenance Tools
        if (1) {
            $tools[] = [
                'name'	   => 'Trans From OC',
                'href'     => route('lang.admin.system.maintenance.tools.trans_from_opencart'),
                'icon'	   => ' ',
                'children' => []
            ];
        }
        
        if(!empty($tools)) {
            $maintenance[] = [
                'id'       => 'menu-tools',
                'icon'	   => ' ',
                'name'	   => 'Tools',
                'children' => $tools
            ];
        }

        
        if ($maintenance) {
            $system[] = [
                'name'	   => 'Maintenance',
                'icon'	   => ' ',
                'children' => $maintenance
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

        /**
         * Example
         */
        // L2
        if(1) {
            $example[] = [
                'name'	   => 'L2 example 0',
                'icon'	   => '',
                'href'     => '/',
                'children' => []
            ];
        }
        if(1) {
            $example[] = [
                'name'	   => 'L2 example 1',
                'icon'	   => '',
                'href'     => '/',
                'children' => []
            ];
        }

        // 
        $level_2 = [];

        if (1) {
            $level_2[] = [
                'name'	   => 'L3 example 0',
                'href'     => '/',
                'icon'	   => ' ',
            ];
        }

        // L3
        if (1) {
            $level_2[] = [
                'name'	   => 'L3 example 1',
                'href'     => '/',
                'icon'	   => ' ',
            ];
        }

        // Level3a
        if (1) {
            $level_3a[] = [
                'name'	   => 'L4 example 0',
                'href'     => '/',
                'icon'	   => ' ',
            ];
        }
        if (1) {
            $level_3a[] = [
                'name'	   => 'L4 example 1',
                'href'     => '/',
                'icon'	   => ' ',
            ];
        }

        if ($level_3a) {
            $level_2[] = [
                'name'	   => 'L3 example 2',
                'icon'	   => ' ',
                'children' => $level_3a
            ];
        }

        // level_3b
        if (1) {
            $level_3b[] = [
                'name'	   => 'L4 example 0',
                'href'     => '/',
                'icon'	   => ' ',
            ];
        }
        if (1) {
            $level_3b[] = [
                'name'	   => 'L4 example 1',
                'href'     => '/',
                'icon'	   => ' ',
            ];
        }

        if ($level_3b) {
            $level_2[] = [
                'name'	   => 'L3 example 3',
                'icon'	   => ' ',
                'children' => $level_3b
            ];
        }

        if ($level_2) {
            $example[] = [
                'name'	   => 'L2 example 2',
                'icon'	   => ' ',
                'children' => $level_2
            ];
        }

        if(!empty($example)) {
            $menus[] = [
                'id'       => 'menu-example',
                'icon'	   => 'fas fa-cog',
                'name'	   => 'Example',
                'href'     => '',
                'children' => $example
            ];
        }

        return $menus;
    }
}
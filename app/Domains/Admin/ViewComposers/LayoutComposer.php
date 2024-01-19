<?php

namespace App\Domains\Admin\ViewComposers;

use Illuminate\View\View;
use App\Libraries\TranslationLibrary;

class LayoutComposer
{
    private $lang;
    private $auth_user;
    private $acting_user;
    private $base;
    
    /**
     * Create a new sidebar composer.
     *
     * @param  ...
     * @return void
     */
    //public function __construct(UserRepository $users)
    public function __construct()
    {
        $this->auth_user = auth()->user();
        $this->acting_user = auth()->user();
        $this->lang = (new TranslationLibrary())->getTranslations(['admin/common/common','admin/common/column_left']);
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('auth_user', $this->auth_user);
        $view->with('acting_user', $this->acting_user);
        $view->with('navigation', $this->lang->text_navigation);
        
        $leftMenus = $this->getColumnLeft();
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

        
        /**
         * 商品管理
         */
        if(1) {
            $product[] = [
                'name'	   => '屬性',
                'icon'	   => '',
                'href'     => 'javascript:void(0)',
                'children' => []
            ];
        }
        
        if(1) {
            $product[] = [
                'name'	   => '選項',
                'icon'	   => '',
                'href'     => 'javascript:void(0)',
                'children' => []
            ];
        }

        if(1) {
            $product[] = [
                'name'	   => '商品',
                'icon'	   => '',
                'href'     => route('lang.admin.catalog.products.index', ['equal_is_active' => 1]),
                'children' => []
            ];
        }

        if(1){
            $menus[] = [
                'id'       => 'menu-product',
                'icon'	   => 'fas fa-cog',
                'name'	   => '商品管理',
                'href'     => '',
                'children' => $product
            ];
        }



        
        /**
         * 帳號權限
         */
        // L2
        if(1) {
            $example[] = [
                'name'	   => '帳號',
                'icon'	   => '',
                'href'     => route('lang.admin.user.users.index'),
                'children' => []
            ];
        }
        if(1) {
            $example[] = [
                'name'	   => '權限',
                'icon'	   => '',
                'href'     => '/',
                'children' => []
            ];
        }
        if(1) {
            $example[] = [
                'name'	   => '角色',
                'icon'	   => '',
                'href'     => '/',
                'children' => []
            ];
        }

        //
        $level_2 = [];

        if(1){
            $menus[] = [
                'id'       => 'menu-account',
                'icon'	   => 'fas fa-cog',
                'name'	   => '帳號權限',
                'href'     => '',
                'children' => $example
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

        // Localisation Languages
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

        //if(!empty($example)) {
        if(0){
            $menus[] = [
                'id'       => 'menu-system',
                'icon'	   => 'fas fa-cog',
                'name'	   => 'Example',
                'href'     => '',
                'children' => $example
            ];
        }

        return $menus;
    }
}

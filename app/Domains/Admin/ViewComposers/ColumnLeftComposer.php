<?php

namespace App\Domains\Admin\ViewComposers;

use Illuminate\View\View;
use App\Libraries\TranslationLibrary;

class ColumnLeftComposer
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
         * 帳號權限
         */
        // L2
        if(1) {
            $userParent[] = [
                'name'	   => $this->lang->columnleft_user_user,
                'icon'	   => '',
                'href'     => route('lang.admin.user.users.index'),
                'children' => []
            ];
        }
        if(1) {
            $userParent[] = [
                'name'	   => $this->lang->columnleft_permission,
                'icon'	   => '',
                'href'     => route('lang.admin.user.permissions.index'),
                'children' => []
            ];
        }
        if(1) {
            $userParent[] = [
                'name'	   => $this->lang->columnleft_role,
                'icon'	   => '',
                'href'     => route('lang.admin.user.roles.index'),
                'children' => []
            ];
        }

        //
        $level_2 = [];

        if(1){
            $menus[] = [
                'id'       => 'menu-account',
                'icon'	   => 'fas fa-cog',
                'name'	   => $this->lang->columnleft_user,
                'href'     => '',
                'children' => $userParent
            ];
        }

        
        /**
         * 系統管理
         */

        //
        $level_2 = [];

        // Localisation Languages
        if (1) {
            $level_2[] = [
                'name'	   => '詞彙分類',
                'href'     => route('lang.admin.system.term.taxonomies.index'),
                'icon'	   => ' ',
            ];
        }

        // L3
        if (1) {
            $level_2[] = [
                'name'	   => '詞彙',
                'href'     => route('lang.admin.system.term.terms.index'),
                'icon'	   => ' ',
            ];
        }

        if ($level_2) {
            $system[] = [
                'name'	   => '詞彙管理',
                'icon'	   => ' ',
                'children' => $level_2
            ];
        }

        //if(!empty($example)) {
        if(1){
            $menus[] = [
                'id'       => 'menu-example',
                'icon'	   => 'fas fa-cog',
                'name'	   => '系統管理',
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

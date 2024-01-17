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
        $this->lang = (new TranslationLibrary())->getTranslations(['common/common','common/column_left']);
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

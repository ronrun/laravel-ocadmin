<?php

namespace App\Domains\Admin\Traits;

use Illuminate\Http\Request;

trait MenuTrait {

    public function getMenus()
    {
        $menus[] = [
            'id'       => 'menu-dashboard',
            'icon'	   => 'fas fa-home',
            'name'	   => 'Dashboard',
            'href'     => route('lang.admin.dashboard'),
            'children' => []
        ];

        // System
        $system = [];

        // System / Setting
        if (1) {
            $system[] = [
                'name'	   => 'Setting',
                'icon'	   => ' ',
                'href'     => route('lang.admin.system.settings.index'),
                'children' => []
            ];
        }

        // System / User (Users, Roles, Permissions)
        $user = [];

        if (1) {
            $user[] = [
                'name'	   => 'Users',
                'icon'	   => ' ',
                'href'     => route('lang.admin.system.user.users.index'),
                'children' => []
            ];
        }

        if (1) {
            $user[] = [
                'name'	   => 'Roles',
                'icon'	   => ' ',
                'href'     => route('lang.admin.system.user.roles.index'),
                'children' => []
            ];
        }

        if ($user) {
            $system[] = [
                'name'	   => 'User',
                'icon'	   => ' ',
                'href'     => '',
                'children' => $user
            ];
        }

        if ($system) {
            $menus[] = [
                'id'       => 'menu-system',
                'icon'	   => 'fas fa-tag',
                'name'	   => 'System',
                'href'     => '',
                'children' => $system
            ];
        }
        //echo "<pre>", print_r($menus, 1), "</pre>"; exit;

        return $menus;
    }
}
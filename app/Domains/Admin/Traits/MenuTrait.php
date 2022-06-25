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
        /*
        // Sales
        $sales = [];

        // Sales / Orders
        if (1) {
            $sales[] = [
                'name'	   => 'Orders',
                'icon'	   => '',
                'href'     => route('lang.admin.sales.orders.index'),
                'children' => []
            ];
        }

        // add to Menus
        if ($sales) {
            $menus[] = [
                'id'       => 'menu-sales',
                'icon'	   => 'fas fa-tag',
                'name'	   => 'Sales',
                'href'     => '',
                'children' => $sales
            ];
        }
        */

        // Catalog
        $catalog = [];
        /*
        // Catalog / Category
        if (1) {
            $catalog[] = [
                'name'	   => 'Categorie',
                'icon'	   => '',
                'href'     => route('lang.admin.catalog.categories.index'),
                'children' => []
            ];
        }

        // Catalog / Product
        if (1) {
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

        // if (1) {
        //     $meta[] = [
        //         'name'	   => 'Categories',
        //         'icon'	   => ' ',
        //         'href'     => route('lang.admin.system.user.users.index'),
        //         'children' => []
        //     ];
        // }

        if (1) {
            $meta[] = [
                'name'	   => 'Products',
                'icon'	   => ' ',
                'href'     => route('lang.admin.catalog.products.showMetaForm'),
                'children' => []
            ];
        }

        if ($meta) {
            $catalog[] = [
                'name'	   => 'Update Meta',
                'icon'	   => ' ',
                'href'     => '',
                'children' => $meta
            ];
        }

        // add to Menus
        if ($catalog) {
            $menus[] = [
                'id'       => 'menu-catalog',
                'icon'	   => 'fas fa-tag',
                'name'	   => 'Catalog',
                'href'     => '',
                'children' => $catalog
            ];
        }

        // Members
        $members = [];

        // Members / Members
        if (1) {
            $member[] = [
                'name'	   => 'Members',
                'icon'	   => '',
                'href'     => route('lang.admin.member.members.index'),
                'children' => []
            ];
        }

        // add to Menus
        if ($member) {
            $menus[] = [
                'id'       => 'menu-members',
                'icon'	   => 'fas fa-tag',
                'name'	   => 'Members',
                'href'     => '',
                'children' => $member
            ];
        }

        // Tools
        $tools = [];

        // Tools / Setting
        if (1) {
            $tools[] = [
                'name'	   => 'Translations',
                'icon'	   => '',
                'href'     => route('lang.admin.tools.trans_from_opencart'),
                'children' => []
            ];
        }

        // add to Menus
        if ($tools) {
            $menus[] = [
                'id'       => 'menu-tools',
                'icon'	   => 'fas fa-tag',
                'name'	   => 'Tools',
                'href'     => '',
                'children' => $tools
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

        return $menus;
    }
}
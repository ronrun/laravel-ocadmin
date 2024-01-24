<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => config('app.admin_folder'),
    'namespace' => 'App\Domains\Admin\Http\Controllers',
    'as' => 'admin.',
], function ()
{
    // auth 路由：不需登入
    Route::group([
        'middleware' => ['guest'],
    ], function ()
    {
        Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('/login', 'Auth\LoginController@login');
    });

    Route::group([
        'middleware' => ['is_admin'],
    ], function ()
    {
        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('', 'DashboardController@index')->name('dashboard');

        Route::group([
            'prefix' => 'user',
            'as' => 'user.',
        ], function ()
        {
            Route::get('users', 'User\UserController@index')->name('users.index');
            Route::get('users/form/{id?}', 'User\UserController@form')->name('users.form');
            Route::get('users/list', 'User\UserController@list')->name('users.list');
            Route::post('users/save/{id?}', 'User\UserController@save')->name('users.save');
            Route::post('users/destroy', 'User\UserController@destroy')->name('users.destroy');
            
            Route::get('permissions', 'User\PermissionController@index')->name('permissions.index');
            Route::get('permissions/form/{id?}', 'User\PermissionController@form')->name('permissions.form');
            Route::get('permissions/list', 'User\PermissionController@list')->name('permissions.list');
            Route::post('permissions/save/{id?}', 'User\PermissionController@save')->name('permissions.save');
            Route::post('permissions/destroy', 'User\PermissionController@destroy')->name('permissions.destroy');
            
            Route::get('roles', 'User\RoleController@index')->name('roles.index');
            Route::get('roles/form/{id?}', 'User\RoleController@form')->name('roles.form');
            Route::get('roles/list', 'User\RoleController@list')->name('roles.list');
            Route::post('roles/save/{id?}', 'User\RoleController@save')->name('roles.save');
            Route::post('roles/destroy', 'User\RoleController@destroy')->name('roles.destroy');
    
        });
    
        Route::group([
            'prefix' => 'catalog',
            'as' => 'catalog.',
        ], function ()
        {
    
            //商品基本資料
            Route::get('products', 'Catalog\ProductController@index')->name('products.index');
            Route::get('products/form/{product_id?}', 'Catalog\ProductController@form')->name('products.form');
            Route::get('products/list', 'Catalog\ProductController@list')->name('products.list');
            Route::get('products/autocomplete', 'Catalog\ProductController@autocomplete')->name('products.autocomplete');
            Route::post('products/save/{product_id?}', 'Catalog\ProductController@save')->name('products.save');
            Route::post('products/destroy', 'Catalog\ProductController@destroy')->name('products.destroy');
        }); 

    });  
    



}); 
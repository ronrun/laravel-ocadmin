<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => ['is_admin'],
    'namespace' => 'App\Domains\Admin\Http\Controllers',
    'as' => 'admin.',
], function ()
{

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
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(  
    [  
    'prefix' => LaravelLocalization::setLocale(),  
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
    'as' => 'lang.'
    ], function()  
{
    Route::group([
        'namespace' => 'App\Domains\Admin\Http\Controllers',
        'prefix' => env('APP_ADMIN_PATH', '/admin'),
        'as' => 'admin.',
        'middleware' => [ 'is_admin',],
    ], function ()
    {
        Route::get('', function () {
            return redirect(route('lang.admin.dashboard'));
        });
        Route::get('/dashboard', 'Common\DashboardController@index')->name('dashboard');

        Route::group([
            'prefix' => 'post',
            'as' => 'post.',
        ], function ()
        {
            Route::get('tags', 'Post\TagController@index')->name('tags.index');
            Route::get('tags/list', 'Post\TagController@list')->name('tags.list');
            Route::get('tags/form/{tag_id?}', 'Post\TagController@form')->name('tags.form');
            Route::post('tags/save/{tag_id?}', 'Post\TagController@save')->name('tags.save');
            
            Route::get('categories', 'Post\CategoryController@index')->name('categories.index');
            Route::get('categories/list', 'Post\CategoryController@list')->name('categories.list');
            Route::get('categories/form/{category_id?}', 'Post\CategoryController@form')->name('categories.form');
            Route::post('categories/save/{category_id?}', 'Post\CategoryController@save')->name('categories.save');

            Route::get('posts', 'Post\PostController@index')->name('posts.index');
            Route::get('posts/list', 'Post\PostController@list')->name('posts.list');
            Route::get('posts/form/{tag_id?}', 'Post\PostController@form')->name('posts.form');
            Route::post('posts/save/{tag_id?}', 'Post\PostController@save')->name('posts.save');
        });

        Route::group([
            'prefix' => 'catalog',
            'as' => 'catalog.',
        ], function ()
        {
            
            Route::get('categories', 'Catalog\CategoryController@index')->name('categories.index');
            Route::get('categories/list', 'Catalog\CategoryController@list')->name('categories.list');
            Route::get('categories/form/{category_id?}', 'Catalog\CategoryController@form')->name('categories.form');
            Route::post('categories/save/{category_id?}', 'Catalog\CategoryController@save')->name('categories.save');

            Route::get('tags', 'Catalog\TagController@index')->name('tags.index');
            Route::get('tags/list', 'Catalog\TagController@list')->name('tags.list');
            Route::get('tags/form/{tag_id?}', 'Catalog\TagController@form')->name('tags.form');
            Route::post('tags/save/{tag_id?}', 'Catalog\TagController@save')->name('tags.save');
            
            Route::get('attributes', 'Catalog\AttributeController@index')->name('attributes.index');
            Route::get('attributes/list', 'Catalog\AttributeController@list')->name('attributes.list');
            Route::get('attributes/form/{tag_id?}', 'Catalog\AttributeController@form')->name('attributes.form');
            Route::post('attributes/save/{tag_id?}', 'Catalog\AttributeController@save')->name('attributes.save');
            
            Route::get('options', 'Catalog\OptionController@index')->name('options.index');
            Route::get('options/list', 'Catalog\OptionController@list')->name('options.list');
            Route::get('options/form/{option_id?}', 'Catalog\OptionController@form')->name('options.form');
            Route::post('options/save/{option_id?}', 'Catalog\OptionController@save')->name('options.save');
            
            Route::get('filters', 'Catalog\FilterController@index')->name('filters.index');
            Route::get('filters/list', 'Catalog\FilterController@list')->name('filters.list');
            Route::get('filters/form/{tag_id?}', 'Catalog\FilterController@form')->name('filters.form');
            Route::post('filters/save/{tag_id?}', 'Catalog\FilterController@save')->name('filters.save');

            Route::get('products', 'Catalog\ProductController@index')->name('products.index');
            Route::get('products/list', 'Catalog\ProductController@list')->name('products.list');
            Route::get('products/form/{tag_id?}', 'Catalog\ProductController@form')->name('products.form');
            Route::post('products/save/{tag_id?}', 'Catalog\ProductController@save')->name('products.save');
        });

        Route::group([
            'prefix' => 'system',
            'as' => 'system.',
        ], function ()
        {

            Route::group([
                'prefix' => 'admin',
                'as' => 'admin.',
            ], function ()
            {
                Route::get('users', 'User\UserController@index')->name('users.index');
                Route::get('users/list', 'User\UserController@list')->name('users.list');
                Route::get('users/autocomplete', 'User\UserController@autocomplete')->name('users.autocomplete');
                Route::get('users/form/{user_id?}', 'User\UserController@form')->name('users.form');
                Route::put('users/save/{user_id?}', 'User\UserController@save')->name('users.save');
                
                Route::get('roles', 'User\RoleController@index')->name('roles.index');
                Route::get('roles/list', 'User\RoleController@list')->name('roles.list');
                Route::get('roles/autocomplete', 'User\RoleController@autocomplete')->name('roles.autocomplete');
                Route::get('roles/form/{role_id?}', 'User\RoleController@form')->name('roles.form');
                Route::put('roles/save/{role_id?}', 'User\RoleController@save')->name('roles.save');
    
                Route::get('permissions', 'User\PermissionController@index')->name('permissions.index');
                Route::get('permissions/form/{permission_id?}', 'User\PermissionController@form')->name('permissions.form');
                Route::get('permissions/list', 'User\PermissionController@list')->name('permissions.list');
                Route::get('permissions/autocomplete', 'User\PermissionController@autocomplete')->name('permissions.autocomplete');
                Route::put('permissions/save/{permission_id?}', 'User\PermissionController@save')->name('permissions.save');
            }); 

            Route::group(['prefix' => 'maintenance', 'as' => 'maintenance.'], function (){
                Route::group(['prefix' => 'tools', 'as' => 'tools.'], function (){
                    Route::get('trans-from-opencart', 'Tools\TransFromOpencartController@getForm')->name('trans_from_opencart');
                    Route::post('trans-from-opencart', 'Tools\TransFromOpencartController@update');

                });
            });

        }); 
    });   
});  

/*
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/
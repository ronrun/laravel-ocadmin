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
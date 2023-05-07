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
        Route::get('/dashboard', 'Common\DashboardController@index')->name('dashboard');

        Route::group([
            'prefix' => 'user',
            'as' => 'user.',
        ], function ()
        {
            Route::get('user', 'User\UserController@index')->name('user.index');
            Route::get('user/form/{user_id?}', 'User\UserController@form')->name('user.form');
            Route::get('user/list', 'User\UserController@list')->name('user.list');
            Route::get('user/autocomplete', 'User\UserController@autocomplete')->name('user.autocomplete');
            Route::put('user/save/{user_id?}', 'User\UserController@save')->name('user.save');
            
            Route::get('role', 'User\RoleController@index')->name('role.index');
            Route::get('role/form/{role_id?}', 'User\RoleController@form')->name('role.form');
            Route::get('role/list', 'User\RoleController@list')->name('role.list');
            Route::get('role/autocomplete', 'User\RoleController@autocomplete')->name('role.autocomplete');
            Route::put('role/save/{role_id?}', 'User\RoleController@save')->name('role.save');

            Route::get('permission', 'User\PermissionController@index')->name('permission.index');
            Route::get('permission/form/{permission_id?}', 'User\PermissionController@form')->name('permission.form');
            Route::get('permission/list', 'User\PermissionController@list')->name('permission.list');
            Route::get('permission/autocomplete', 'User\PermissionController@autocomplete')->name('permission.autocomplete');
            Route::put('permission/save/{permission_id?}', 'User\PermissionController@save')->name('permission.save');
        }); 

        Route::group([
            'prefix' => 'system',
            'as' => 'system.',
        ], function ()
        {
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
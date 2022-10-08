<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
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
        'prefix' => config('config.admin_folder'),
        'middleware' => [ 'is_admin',],
        'namespace' => 'App\Domains\Ocadmin\Http\Controllers',
        'as' => 'admin.',
    ], function ()
    {
        Auth::routes();

        Route::get('', 'Common\DashboardController@index')->name('dashboard');

        Route::group([
            'prefix' => 'member',
            'as' => 'member.',
        ], function ()
        {
            Route::get('members', 'Member\MemberController@index')->name('members.index');
            Route::get('members/form/{member_id?}', 'Member\MemberController@form')->name('members.form');
            Route::get('members/list', 'Member\MemberController@list')->name('members.list');
            Route::get('members/autocomplete', 'Member\MemberController@autocomplete')->name('members.autocomplete');
            Route::put('members/save/{member_id?}', 'Member\MemberController@save')->name('members.save');
    
            Route::get('organizations', 'Member\OrganizationController@index')->name('organizations.index');
            
        });

        Route::group([
            'prefix' => 'system',
            'as' => 'system.',
        ], function ()
        {
            Route::group([
                'prefix' => 'setting',
                'as' => 'setting.',
            ], function ()
            {
                Route::get('stores', 'Setting\StoreController@index')->name('stores.index');
                Route::get('stores/list', 'Setting\StoreController@list')->name('stores.list');
                Route::get('stores/edit/{organization_id}', 'Setting\StoreController@form')->name('stores.edit');
                //Route::put('stores/save', 'Setting\StoreController@save')->name('stores.save');

                Route::get('settings', 'Setting\SettingController@index')->name('settings.index');
                Route::put('settings', 'Setting\SettingController@save')->name('settings.save');


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

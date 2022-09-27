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
        Route::get('', 'Common\DashboardController@index')->name('dashboard');

        Route::group([
            'prefix' => 'system',
            'as' => 'system.',
        ], function ()
        {
            Route::get('/settings', 'Setting\SettingController@index')->name('settings.index');
    
    
        });
        
        // Route::get('/', function () {
        //     //return 'dashboard';
        //     return view('ocadmin.dashboard');
        // });

    });
});

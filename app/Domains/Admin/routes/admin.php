<?php
use Illuminate\Support\Facades\Route;

Route::group(  
    [  
    'prefix' => LaravelLocalization::setLocale(),  
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
    'as' => 'lang.'
    ], function()
{
    $locale = LaravelLocalization::setLocale();
    $backend = env('FOLDER_ADMIN');
    $dir_backend = '/' . $locale . '/' . $backend;

    //login logou register... as lang. admin. is needed in advanced
    //No need to use auth middleware in group rules, for login route in auth::routes().
    Route::group([
        'namespace' => 'App\Domains\Admin\Http\Controllers',
        'prefix' => $backend,
        'as' => 'admin.',
    ], function () use($backend)
    {
        Auth::routes();

        Route::group(['middleware' => ['auth:admin'],], function () use($backend){
            //下面可以使用但很長
            //Route::get('', [App\Domains\Admin\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
            //下面用陣列型式無法單獨使用，必須在檔案開頭加上 use。
            //Route::get('', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('', 'DashboardController@index')->name('dashboard');

            Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () use($backend) {
                Route::resource('orders', Sales\OrderController::class);
            });

            Route::group(['prefix' => 'member', 'as' => 'member.'], function () use($backend) {
                Route::resource('members', Member\MemberController::class);
            });

            Route::group(['prefix' => 'tools', 'as' => 'tools.'], function () use($backend) {
                Route::get('trans-from-opencart', 'Tools\TransFromOpencartController@getForm')->name('trans_from_opencart');
                Route::post('trans-from-opencart', 'Tools\TransFromOpencartController@update');
            });
            
            Route::group(['prefix' => 'system', 'as' => 'system.'], function () use($backend) {
                Route::resource('settings', System\SettingController::class);
                Route::group(['prefix' => 'user', 'as' => 'user.'], function () use($backend) {
                    Route::resource('users', System\User\UserController::class);
                    Route::resource('roles', System\User\UserController::class);
                });
            });
        }); 
    });

});

?>
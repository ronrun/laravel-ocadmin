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
            Route::get('', 'DashboardController@index')->name('dashboard');

            Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () use($backend) {
                Route::resource('orders', Sales\OrderController::class);
            });

            Route::group(['prefix' => 'member', 'as' => 'member.'], function () use($backend) {
                Route::get('members/autocomplete', 'Member\MemberController@autocomplete')->name('members.autocomplete');
                Route::post('members/ex/massdelete', 'Member\MemberController@massDelete')->name('members.massdelete');
                Route::get('members/ip/{member_id}', 'Member\MemberController@ip')->name('members.ip');
                Route::get('members/list', 'Member\MemberController@list')->name('members.list');
                Route::resource('members', Member\MemberController::class);
            });

            Route::group(['prefix' => 'tools', 'as' => 'tools.'], function () use($backend) {
                Route::get('trans-from-opencart', 'Tools\TransFromOpencartController@getForm')->name('trans_from_opencart');
                Route::post('trans-from-opencart', 'Tools\TransFromOpencartController@update');
            });
            
            Route::group(['prefix' => 'system', 'as' => 'system.'], function () use($backend) {
                Route::resource('settings', System\SettingController::class);
                Route::group(['prefix' => 'user', 'as' => 'user.'], function () use($backend) {
                    Route::get('users/list', 'System\User\UserController@list')->name('users.list');
                    Route::resource('users', System\User\UserController::class);
                    Route::resource('roles', System\User\UserController::class);
                });
            });

        });
    });
});

?>
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

            Route::group(['prefix' => 'catalog', 'as' => 'catalog.'], function () use($backend) {
                Route::get('categories/autocomplete', 'Catalog\CategoryController@autocomplete')->name('categories.autocomplete');
                Route::get('categories/list', 'Catalog\CategoryController@list')->name('categories.list');
                Route::resource('categories', Catalog\CategoryController::class);
                
                Route::get('products/autocomplete', 'Catalog\ProductController@autocomplete')->name('products.autocomplete');
                Route::get('products/list', 'Catalog\ProductController@list')->name('products.list');
                Route::resource('products', Catalog\ProductController::class);
                
            });
    
            Route::group(['prefix' => 'member', 'as' => 'member.'], function () use($backend) {
                Route::get('members/autocomplete', 'Member\MemberController@autocomplete')->name('members.autocomplete');
                //Route::post('members/massdelete', 'Member\MemberController@massDelete')->name('members.massdelete');
                Route::get('members/ip/{member_id}', 'Member\MemberController@ip')->name('members.ip');
                Route::get('members/list', 'Member\MemberController@list')->name('members.list');
                Route::get('members/form/{member_id?}', 'Member\MemberController@form')->name('members.form');
                Route::put('members/save/{member_id?}', 'Member\MemberController@save')->name('members.save');
                //Route::resource('members', Member\MemberController::class);
                Route::get('members', 'Member\MemberController@index')->name('members.index');
            });

            Route::group(['prefix' => 'tools', 'as' => 'tools.'], function () use($backend) {
                Route::get('trans-from-opencart', 'Tools\TransFromOpencartController@getForm')->name('trans_from_opencart');
                Route::post('trans-from-opencart', 'Tools\TransFromOpencartController@update');
            });
            
            Route::group(['prefix' => 'system', 'as' => 'system.'], function () use($backend) {
                Route::resource('settings', System\SettingController::class);

                Route::group(['prefix' => 'user', 'as' => 'user.'], function () use($backend) {
                    Route::get('users/autocomplete', 'System\User\UserController@autocomplete')->name('users.autocomplete');
                    Route::get('users/ip/{user_id}', 'System\User\UserController@ip')->name('users.ip');
                    Route::get('users/list', 'System\User\UserController@list')->name('users.list');
                    Route::get('users/form/{user_id?}', 'System\User\UserController@form')->name('users.form');
                    Route::put('users/save/{user_id?}', 'System\User\UserController@save')->name('users.save');
                    Route::get('users', 'System\User\UserController@index')->name('users.index');
                    
                    Route::resource('roles', System\User\UserController::class);
                });
            });

        });
    });
});

?>
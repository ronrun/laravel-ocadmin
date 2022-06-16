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

        });
    });
});

?>
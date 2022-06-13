<?php
use Illuminate\Support\Facades\Route;

//use App\Domains\Admin\Http\Controllers\System\User\UserController;

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
    //No auth middleware in group rules. If needed, do in controller
    Route::group([
        'namespace' => 'App\Domains\Admin\Http\Controllers',
        'prefix' => $backend,
        'as' => 'admin.',
    ], function () use($backend)
    {
        Auth::routes();

        Route::group(['middleware' => ['auth:admin'],], function () use($backend){
            Route::get('', [App\Domains\Admin\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

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
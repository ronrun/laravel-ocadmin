<?php
use Illuminate\Support\Facades\Route;

$backend = env('FOLDER_ADMIN');

//Language
Route::group(  
    [  
    'prefix' => LaravelLocalization::setLocale(),  
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
    'as' => 'lang.'
    ], function() use($backend)
{
    //Backend(Admin) prefix
    Route::group(['prefix' => $backend], function () use($backend) {
        Route::redirect('', $backend.'/dashboard');
    
        Route::group(['middleware' => 'auth:admin'], function () {
            Route::get('dashboard', [App\Domains\Admin\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('user/users', [App\Domains\Admin\Http\Controllers\System\User\UserController::class, 'index'])->name('admin.system.user');
        });
    
        Route::group([
            'namespace' => 'App\Domains\Admin\Http\Controllers',
            'as' => 'admin.',
        ], function () {
            Auth::routes();
        });
    });

});



?>
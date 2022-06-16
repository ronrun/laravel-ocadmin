<?php
use Illuminate\Support\Facades\Route;

$backend = env('FOLDER_ADMIN');

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
        //Bellow is ok but too long
        //Route::get('', [App\Domains\Admin\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
        //Bellow cannot be used soly. There should be an use AbcController at top
        //Route::get('', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('', 'DashboardController@index')->name('dashboard');
    }); 
});

?>
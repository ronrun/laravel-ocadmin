<?php
use Illuminate\Support\Facades\Route;

$backend = env('FOLDER_ADMIN');

Route::group(['prefix' => $backend], function () use($backend) {
    Route::redirect('', $backend.'/dashboard');

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('dashboard', [App\Domains\Admin\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
    });

    Route::group([
        'namespace' => 'App\Domains\Admin\Http\Controllers',
        'as' => 'admin.',
    ], function () {
        Auth::routes();
    });
});

?>
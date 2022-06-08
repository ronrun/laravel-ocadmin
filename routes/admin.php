<?php
use Illuminate\Support\Facades\Route;

$backend = env('FOLDER_ADMIN');

Route::group(['prefix' => $backend], function () use($backend) {
    Route::redirect('/', $backend.'/dashboard');
	Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
	Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
	Route::get('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');
	Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout']);

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        // other admin routes...
    });
});
?>
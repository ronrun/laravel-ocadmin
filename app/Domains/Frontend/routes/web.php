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

Route::get('refresh-token', function(){
    return csrf_token();
});

Route::get('/', function () {
    return view('default.welcome');
});


Route::group(['namespace' => 'App\Domains\Frontend\Http\Controllers'], function () {
	Auth::routes();
});
Route::get('/home', [App\Domains\Frontend\Http\Controllers\HomeController::class, 'index'])->name('home');

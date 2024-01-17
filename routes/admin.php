<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => ['is_admin'],
    'namespace' => 'App\Http\Controllers',
    'as' => 'admin.',
], function ()
{

    Route::get('', 'DashboardController@index')->name('dashboard');
}); 
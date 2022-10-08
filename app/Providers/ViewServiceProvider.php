<?php
 
namespace App\Providers;
 
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Domains\Ocadmin\ViewComposers\HeaderComposer;
use App\Domains\Ocadmin\ViewComposers\ColumnLeftComposer;
 
class ViewServiceProvider extends ServiceProvider
{ 
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('ocadmin.app', HeaderComposer::class);
        View::composer('ocadmin.common.column_left', ColumnLeftComposer::class);
    }
}
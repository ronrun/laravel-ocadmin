<?php
 
namespace App\Providers;
 
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Domains\Admin\ViewComposers\LayoutComposer;
 
class ViewServiceProvider extends ServiceProvider
{ 
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('ocadmin.app', LayoutComposer::class);
        View::composer('ocadmin.common.column_left', LayoutComposer::class);
    }
}
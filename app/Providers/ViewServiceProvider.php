<?php
 
namespace App\Providers;
 
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Domains\Admin\ViewComposers\AppComposer;
use App\Domains\Admin\ViewComposers\ColumnLeftComposer;
 
class ViewServiceProvider extends ServiceProvider
{ 
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('admin._layouts.app', AppComposer::class);
        View::composer('admin._layouts.column_left', ColumnLeftComposer::class);
    }
}
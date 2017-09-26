<?php

namespace Menus;

use Illuminate\Support\ServiceProvider;

class MenusServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
            $this->loadViewsFrom(__DIR__.'/views', 'menus');
        }


        /* Composition du sous-menu */
        view()->composer(array('menus::menus'), function($view) {


            $section = Menu::where('nom_sys', Request::segment(1))->get();
            $menus = Menu::where('parent_id', $section[0]->id)->get();

            $view->with(compact('menus'));
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Connection::class, function ($app) {
            return new Connection(config('menus'));
        });    
    }
}

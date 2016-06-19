<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'profile', 'App\ViewComposers\DispoComposer'
            );

        view()->composer(
            'accueil', 'App\ViewComposers\AccueilComposer'
            );    

        view()->composer(
            'layouts.app', 'App\ViewComposers\LayoutComposer'
            );    
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

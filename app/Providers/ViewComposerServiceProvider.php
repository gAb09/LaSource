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
            'lesrelais', 'App\ViewComposers\GuestRelaisComposer'
            );    

        view()->composer(
            'lesproducteurs', 'App\ViewComposers\GuestProducteurComposer'
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

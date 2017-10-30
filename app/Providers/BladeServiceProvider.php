<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('nbreFR', function ($expression) {
            return "<?php echo
            number_format($expression, 2, ',', ' ');
            ?>";
        });

        Blade::directive('prixFR_E', function ($expression) {
            return "<?php echo
            number_format($expression, 2, ',', ' ').'&nbsp;&euros;';
            ?>";
        });

        Blade::directive('prixFR', function ($expression) {
            return "<?php echo
            number_format($expression, 2, ',', ' ').'&nbsp;euros';
            ?>";
        });

        Blade::directive('date_complete', function ($expression) { 
            return "<?php echo
            \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $expression)->formatLocalized('%A %e %B %Y');
            ?>";
        });

        Blade::directive('nobr', function ($expression) { 
            return "<?php echo
            str_replace('<br/>', ' ', $expression);
            ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

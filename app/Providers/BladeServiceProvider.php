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
        Blade::directive('prix', function ($expression) {
            return "<?php echo
            number_format($expression, 2, ',', ' ').'&nbsp;&euro;';
            ?>";
        });

        Blade::directive('date_complete', function ($expression) {
          $formattedDate = \Carbon\Carbon::createFromFormat('Y-m', '2017-01')->formatLocalized('%A %e %B %Y');
            return "<?php echo
            '$formattedDate';
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

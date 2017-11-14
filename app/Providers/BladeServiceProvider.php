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

        Blade::directive('date_eB', function ($expression) { 
            return "<?php echo
            \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $expression)->formatLocalized('%e %B');
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

// – – – – – – – – – –  tokens php pour les dates – – – – – – – – – – – – – – 
    /* A
    ** Jour du mois en lettre.
    */

    /* d
    ** Jour du mois en numérique, sur 2 chiffres (avec le zéro initial).
    ** De 01 à 31
    */

    /* e
    ** Jour du mois, avec un espace précédant le premier chiffre.
    ** De 1 à 31
    */

    /* B
    ** Nom du mois, complet, suivant la locale.
    ** De janvier à décembre.
    */

    /* b
    ** Nom du mois, abrégé, suivant la locale.
    ** De jan à déc.
    */

    /* m
    ** Mois, sur 2 chiffres.
    ** De 01 (pour Janvier) à 12 (pour Décembre).
    */

    /* Y
    ** L’année, sur 4 chiffres.
    ** Exemple : 2038
    */


}

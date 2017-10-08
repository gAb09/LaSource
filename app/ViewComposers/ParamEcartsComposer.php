<?php

namespace App\ViewComposers;

use App\Models\Parameter as Parameter;

use Illuminate\View\View;

class ParamEcartsComposer
{

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $marge_cloture_now = Parameter::where('param', 'marge_cloture_now')->first();
        $marge_cloture_paiement = Parameter::where('param', 'marge_cloture_paiement')->first();
        $marge_paiement_livraison = Parameter::where('param', 'marge_paiement_livraison')->first();
        $view->with(compact('marge_cloture_now', 'marge_cloture_paiement', 'marge_paiement_livraison'));
    }
}
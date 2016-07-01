<?php

namespace App\ViewComposers;

use App\Domaines\PanierDomaine as Paniers;

use Illuminate\View\View;

class ChoisirPaniersComposer
{
    /**
     * The Paniers domaine implementation.
     *
     * @var PanierDomaine
     */
    protected $domaine;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(Paniers $domaine)
    {
        $this->domaine = $domaine;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $paniers = $this->domaine->choixPaniers();
        $view->with(compact('paniers'));
    }
}
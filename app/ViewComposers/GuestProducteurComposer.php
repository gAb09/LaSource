<?php

namespace App\ViewComposers;

use App\Domaines\ProducteurDomaine;

use Illuminate\View\View;
use App\Repositories\UserRepository;

class GuestProducteurComposer
{
    /**
     * The producteur repository implementation.
     *
     * @var ProducteurDomaine
     */
    protected $domaine;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(ProducteurDomaine $domaine)
    {
        $this->domaine = $domaine;
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
        $producteurs = $this->domaine->allActived('exploitation');
        $view->with(compact('producteurs'));
    }
}
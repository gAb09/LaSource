<?php

namespace App\ViewComposers;

use App\Domaines\ProducteurDomaine as Producteur;

use Illuminate\View\View;
use App\Repositories\UserRepository;

class GuestProducteurComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    // protected $users;

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
        $producteurs = Producteur::all('exploitation');
        $view->with(compact('producteurs'));
    }
}
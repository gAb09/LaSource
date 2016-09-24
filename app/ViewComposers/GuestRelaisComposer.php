<?php

namespace App\ViewComposers;

use App\Domaines\RelaisDomaine;

use Illuminate\View\View;
use App\Repositories\UserRepository;

class GuestRelaisComposer
{
    /**
     * The relais repository implementation.
     *
     * @var RelaisDomaine
     */
    protected $domaine;

    
    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(RelaisDomaine $domaine)
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
        $relaiss = $this->domaine->allActived('ville');
        $view->with(compact('relaiss'));
    }
}
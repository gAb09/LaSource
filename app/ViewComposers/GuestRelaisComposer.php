<?php

namespace App\ViewComposers;

use App\Domaines\RelaisDomaine;

use Illuminate\View\View;
use App\Repositories\UserRepository;

class GuestRelaisComposer
{

    private $domaine;
    
    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(RelaisDomaine $domaine)
    {
        // Dependencies automatically resolved by service container...
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
        $relaiss = $this->domaine->allActifs('ville');
        $view->with(compact('relaiss'));
    }
}
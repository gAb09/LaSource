<?php

namespace App\Listeners;

use App\Events\RetraitPanierEvent;
use App\Domaines\PanierDomaine as Panier;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetraitPanierListener
{

    protected $domaine;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Panier $domaine)
    {
        $this->domaine = $domaine;
    }

    /**
     * Handle the event.
     *
     * @param  RetraitPanierEvent  $event
     * @return void
     */
    public function handle(RetraitPanierEvent $event)
    {
        $result = $this->domaine->checkIfLivraisonLied($event->panier_id);

        if (!$result->isEmpty()) { // Il existe au moins une livraison liée
            $message = 'Oups !! Opération impossible !<br />';
            foreach ($result as $livraison) {
                $message .= trans('message.panier.liedToLivraison', ['date' => $livraison->date_livraison_enClair]).'<br />';
            }
            $message .= \Html::linkRoute('panier.index', 'Retour à la liste');
            return $message;
        }else{
            return null;
        }


        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client;
use App\Models\User;
use App\Domaines\CommandeDomaine;
use App\Domaines\LivraisonDomaine;
use App\Domaines\ModePaiementDomaine;
use App\Domaines\RelaisDomaine;


class EspaceClientController extends Controller
{
    private $commandes_en_cours = [];

    public function __construct(CommandeDomaine $commandesD, LivraisonDomaine $livraisonD, ModePaiementDomaine $modepaiementD, RelaisDomaine $relaissD, Request $request)
    {
        $this->request = $request;
        $this->livraisonD = $livraisonD;
        $this->commandesD = $commandesD;
        $this->modepaiementD = $modepaiementD;
        $this->relaissD = $relaissD;
    }



    public function espaceClient()
    {
        $auth_user = \Auth::user();

        $model = User::with('client.commandes.livraison')->find($auth_user->id);

        $commandesbrutes = $model->load('client.commandes')->client->commandes;
        $commandes = $this->commandesD->getAllLignes($commandesbrutes);
        $commandes = $commandes->each(function($commande) {
            if(in_array($commande->statut, ['C_ARCHIVED', 'C_ARCHIVABLE'])) {
                $commande->en_cours = false;
            }else{
                $commande->en_cours = true;
                $this->commandes_en_cours[] = $commande->livraison->id;
            }
        });
        $commandes_en_cours = $this->commandes_en_cours;

        $livraisons = $this->livraisonD->getAllLivraisonsOuvertes($auth_user);

        $relaiss = $this->relaissD->allActived('id');
        $relaiss->each(function($item) use($model){
            if ($item->id == $model->client->pref_relais) {
                $item->checked = 'checked';
            }else{
                $item->checked = '';
            }
        });

        $modespaiement = $this->modepaiementD->allActived('id');
        $modespaiement->each(function($item) use($model){
            if ($item->id == $model->client->pref_paiement) {
                $item->checked = 'checked';
            }else{
                $item->checked = '';
            }
        });

        return view('espace_client.accueil')->with(compact('model', 'commandes', 'livraisons', 'modespaiement', 'relaiss', 'commandes_en_cours'));
    }


}

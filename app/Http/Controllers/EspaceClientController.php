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
        $auth_user = 87; // ToDo  penser à enlever !!!!

        $model = User::with('client.commandes.livraison')->find($auth_user);

        $commandes = $model->load('client.commandes')->client->commandes;
        $commandes = $this->commandesD->getAllLignes($commandes);

        $livraisons = $this->livraisonD->getAllLivraisonsOuvertes();

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
            if ($item->id == $model->client->pref_mode) {
                $item->checked = 'checked';
            }else{
                $item->checked = '';
            }
        });
        // return dd($model->client->relais);

        return view('espace_client.accueil')->with(compact('model', 'commandes', 'livraisons', 'modespaiement', 'relaiss'));
    }


}

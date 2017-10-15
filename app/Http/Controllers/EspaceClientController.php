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

        $model = User::with('Client.Commandes.Livraison')->find($auth_user);

        $commandes = $model->load('Client.Commandes')->Client->Commandes;
        $commandes = $this->commandesD->getAllLignes($commandes);

        $livraisons = $this->livraisonD->getAllLivraisonsOuvertes();

        $relaiss = $this->relaissD->getForThisClient($auth_user);

        $modespaiement = $this->modepaiementD->getForThisClient($auth_user);
        // return dd($relaiss);

        return view('espace_client.accueil')->with(compact('model', 'commandes', 'livraisons', 'modespaiement', 'relaiss'));
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client;
use App\Models\User;
use App\Domaines\CommandeDomaine;
use App\Domaines\LivraisonDomaine;


class EspaceClientController extends Controller
{


    public function __construct(CommandeDomaine $commandesD, LivraisonDomaine $livraisonD, Request $request)
    {
        $this->request = $request;
        $this->livraisonD = $livraisonD;
        $this->commandesD = $commandesD;
    }



    public function espaceClient()
    {
        $auth_user = \Auth::user();
        $model = User::with('Client.Commandes.Livraison')->find($auth_user->id);

        $commandes = $model->load('Client.Commandes')->Client->Commandes;
        $commandes = $this->commandesD->getAllLignes($commandes);

        $livraisons = $this->livraisonD->getAllLivraisonsOuvertes();

        return view('espace_client.accueil')->with(compact('model', 'commandes', 'livraisons'));
    }


}

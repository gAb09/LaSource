<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client;
use App\Models\User;
use App\Domaines\CommandeDomaine as Domaine;


class EspaceClientController extends Controller
{


    public function __construct(Domaine $commandesD, Request $request)
    {
        $this->commandesD = $commandesD;
        $this->request = $request;
    }



    public function espaceClient()
    {
        $model = \Auth::user();
        $model = User::with('Client.Commandes.Livraison')->find(87);
        $commandes = $model->load('Client.Commandes')->Client->Commandes;
        $commandes = $this->commandesD->getAllLignes($commandes);
// return dd($commandes);
        return view('espace_client.accueil')->with(compact('model', 'commandes'));
    }


}

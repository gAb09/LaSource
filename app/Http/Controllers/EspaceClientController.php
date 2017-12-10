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

        $commandes = $model->load('client.commandes')->client->commandes;

        $commandes = $commandes->each(function($commande) {
            $commande = $this->commandesD->getAllLignes($commande);
            if(in_array($commande->statut, ['C_ARCHIVED', 'C_ARCHIVABLE'])) {
                $commande->en_cours = false;
            }else{
                $commande->en_cours = true;
                $this->commandes_en_cours[] = $commande->livraison->id;
            }
        });
        
        $commandes_en_cours = $this->commandes_en_cours;

        $livraisons = $this->livraisonD->getAllLivraisonsOuvertes($auth_user);



        $livraisons->each(function ($livraison, $keys) use($model){

            $livraison->relais = $livraison->load('relais')->relais;
            $livraison->relais->each(function($item) use($model, $livraison){
                if (!isset($livraison->relais_initial)) {
                    if (!is_null(old($livraison->id.'_relais'))){
                        $livraison->relais_initial = old($livraison->id.'_relais');
                    }elseif ($item->id == $model->client->pref_relais){
                        $livraison->relais_initial = $model->client->pref_relais;
                    }else{
                        $livraison->relais_initial = "";
                    }
                }
            });



            $livraison->modepaiements = $livraison->load('Modepaiements')->Modepaiements;
            $livraison->modepaiements->each(function($item) use($model, $livraison){
                if (!is_null(old($livraison->id.'_paiement'))){
                    $livraison->paiement_initial = old($livraison->id.'_paiement');
                }elseif ($item->id == $model->client->pref_paiement){
                    $livraison->paiement_initial = $model->client->pref_paiement;
                }else{
                    $livraison->paiement_initial = "";
                }
            });

        });

        $all_relais = $this->relaissD->allActived('id');

        $all_modes = $this->modepaiementD->allActived('id');

   // return dd($livraisons);
   // return dd($all_relais);

        return view('espace_client.accueil')->with(compact('model', 'commandes', 'commandes_en_cours', 'livraisons', 'all_relais', 'all_modes'));
    }


}

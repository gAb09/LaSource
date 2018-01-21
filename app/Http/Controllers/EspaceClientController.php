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


    /**
     * Le contrôleur doit fournir
     * – Les données du user (client en l'occurence)
     * – Pour les préférences, l'ensemble des relais actifs
     * – Pour les préférences, l'ensemble des modes de paiements actifs
     * – Les livraisons ouvertes à la commande avec pour chacune,
     *   la détermination du relais et du mode de paiement sélectionné
     *   (prise en compte du choix différent du choix par défaut 
     *   et/ou d'une éventuelle représentation du formulaire si refus de validation )
     * – Les commandes en cours, pour consultation ou pour modification
     * – Les commandes archivées ou archivables.
     *
     * @return void
     * @author 
     **/
    public function espaceClient()
    {
        /* user */
        $user = \Auth::user();

        /* relais actifs */
        $relais_actifs = $this->relaissD->allActived('id');

        /* modes paiements actifs */
        $modes_actifs = $this->modepaiementD->allActived('id');

        /* Livraisons ouvertes */
        $livraisons = $this->livraisonD->getAllLivraisonsOuvertes($user);

        /* détermination du relais et du mode de paiement sélectionné */
        $livraisons->each(function ($livraison, $keys) use($user){

            $livraison->relais = $livraison->load('relais')->relais;
            $livraison->relais->each(function($relai) use($user, $livraison){
                if (!is_null($v = old($livraison->id.'_relais'))){
                    $livraison->relais_selected = $v;
                }elseif(!is_null($v = $user->client->pref_relais)){
                    $livraison->relais_selected = $v;
                }else{
                    $livraison->relais_selected = null;
                }
            });

            $livraison->modepaiements = $livraison->load('Modepaiements')->Modepaiements;
            $livraison->modepaiements->each(function($modepaiement) use($user, $livraison){
                if (!is_null($v = old($livraison->id.'_paiement'))){
                    $livraison->paiement_selected = $v;
                }elseif(!is_null($v = $user->client->pref_paiement)){
                    $livraison->paiement_selected = $v;
                }else{
                    $livraison->paiement_selected = null;
                }
            });
        });


        /* les commandes en cours */
        $commandes_en_cours = $this->commandesD->getCommandesEnCours($user);


        /* les commandes archivées */
        $commandes_archived = $this->commandesD->getCommandesArchived($user);


    return view('espace_client.accueil')->with(compact('user', 'relais_actifs', 'modes_actifs', 'livraisons', 'commandes_en_cours', 'commandes_archived'));
    }

}

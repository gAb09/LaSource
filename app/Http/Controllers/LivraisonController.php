<?php

namespace App\Http\Controllers;

use App\Domaines\LivraisonDomaine;
use App\Domaines\PanierDomaine;
use App\Domaines\ProducteurDomaine;
use App\Domaines\RelaisDomaine;
use App\Domaines\ModePaiementDomaine;
use App\Http\Requests\LivraisonRequest;
use App\Http\Requests\PanierForLivraisonRequest;
use App\Http\Requests\RelaissForLivraisonRequest;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Gab\Helpers\DateFr;

class LivraisonController extends Controller
{
    protected $domaine;
    protected $panier;
    protected $producteur;
    protected $relaiss;
    
    public function __construct(LivraisonDomaine $domaine, PanierDomaine $panier, ProducteurDomaine $producteur, RelaisDomaine $relaiss, ModePaiementDomaine $modepaiements)
    {
        $this->domaine = $domaine;
        $this->panier = $panier;
        $this->producteur = $producteur;
        $this->relaiss = $relaiss;
        $this->modepaiements = $modepaiements;
        $this->domaine_name = $this->domaine->getDomaineName();

    }


    public function index($critere_tri = 'rang', $sens_tri = "asc")
    {
        $models = $this->domaine->index();
        return view('livraison.index')->with(compact('models'));
    }


    public function create()
    {
        $model = $this->domaine->create();
        $date_titrepage = "En création";

        return view('livraison.createdit.create')->with(compact('model', 'date_titrepage'));
    }


    public function store(LivraisonRequest $request)
    {
        $result = $this->domaine->store($request);

        if(is_integer($result)){
            return redirect()->route('livraison.edit', [$result])->with('success', trans('message.livraison.storeOk'));
        }else{
            return redirect()->route('livraison.index')->with('status', trans('message.livraison.storefailed'));
        }
    }


    public function edit($id)
    {
    	$model = $this->domaine->edit($id);

        $paniers_lied = $this->panier->ListForLivraisonEdit($id);

        $relaiss = $this->relaiss->ListForLivraisonEdit($id);

        $modepaiements = $this->modepaiements->ListForLivraisonEdit($id);

        return view('livraison.createdit.edit')->with(compact('model', 'paniers', 'paniers_lied', 'relaiss', 'modepaiements'));
    }


    public function update($id, LivraisonRequest $request)
    {
        if($this->domaine->update($id, $request)){
            return redirect()->back()->with('success', trans('message.livraison.updateOk'));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.updatefailed'));
        }
    }


    public function destroy($id)
    {        
        return dd('Faut-il permettre la suppression ??');
        if($this->domaine->destroy($id)){
            return redirect()->route('livraison.index')->with('success', trans('message.livraison.deleteOk'));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.deletefailed'));
        }

    }

    /**
    * Obtention des données d'affichage des dates :
    * valeur en objet Carbon + libellé en lettre + délai par rapport à aujourd’hui.
    *
    * @param string
    *
    * @return Response json
    **/
    public function getComboDates($valeur)
    {
        $data = $this->domaine->getComboDates($valeur);
        return response()->json($data);
    }


    /**
    * Obtention d'une liste de tous les paniers pour attachement/détachement avec la livraison concernée.
    * Réponse à une requête Ajax.
    *
    * @param integer $livraison_id
    *
    * @return Object View
    **/
    public function listPaniers($livraison_id)
    {
        $model = $this->domaine->findFirst($livraison_id, 'id');

        $paniers = $this->panier->getAllPaniersForLivraisonSynchronisation($livraison_id);

        $titre_page = trans('titrepage.livraison.listPaniers', ['date' => DateFr::complete($model->date_livraison)]);

        return view('livraison.modales.listPaniers')->with(compact('model', 'paniers', 'titre_page'));
    }


    /**
    * Synchronisation avec les paniers (avec ou sans les données pivot : producteur et prix).
    *
    * @param integer $livraison_id
    * @param PanierForLivraisonRequest $request
    *
    * @return Redirection
    **/
    public function syncPaniers($livraison_id, PanierForLivraisonRequest $request)
    {
        // return dd($request);

        $result = $this->domaine->SyncPaniers($livraison_id, $request->except('_token'));

        if (!empty($result)) {
            return redirect()->back()->withInput()->with('success', trans('message.livraison.syncPaniersOk', ['result' => var_dump($result)]));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.syncPaniersfailed'));
        }
    }



    /**
    * Détachement d’un panier depuis la vue édition d’une livraison.
    *
    * @param integer $livraison
    * @param integer $panier
    *
    * @return Redirection
    **/
    public function detachPanier($livraison, $panier)
    {
        $this->domaine->detachPanier($livraison, $panier);
        return redirect()->action('LivraisonController@edit', ['livraison' => $livraison]);
    }



    /**
    * Obtention des infos pour constituer la liste des producteurs liés à l’un des paniers lié à cette livraison.
    *
    * @param integer $panier_id
    *
    * @return Object View
    **/
    public function listProducteursForPanier($panier_id)
    {
        $panier = $this->panier->findFirst($panier_id, 'id');
        $panier->nom_court = str_replace(['<br />', '<br/>'], " - ", $panier->nom_court);

        $producteurs = $this->producteur->listProducteursForPanier($panier_id);
        $titre_page = trans('titrepage.panier.choixproducteurs', ['panier_nomcourt' => $panier->nom_court]);
        return view('livraison.modales.listProducteursForPanier')->with(compact('panier_id', 'producteurs', 'titre_page'));
    }


    /**
    * Synchronisation des relais.
    *
    * @param integer $livraison_id
    * @param Request $request
    *
    * @return Redirection
    **/
    public function syncRelaiss($livraison_id, Request $request)
    {
        $result = $this->domaine->syncRelaiss($livraison_id, $request->except('_token'));
        if (!empty($result)) {
            return redirect()->back()->with('success', trans('message.livraison.syncRelaissOk', ['result' => var_dump($result)]));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.syncRelaissfailed'));
        }
        
    }


    /**
    * Synchronisation des modes de paiement.
    *
    * @param integer $livraison_id
    * @param Request $request
    *
    * @return Redirection
    **/
    public function syncModespaiements($livraison_id, Request $request)
    {
        $result = $this->domaine->syncModespaiements($livraison_id, $request->except('_token'));
        if (!empty($result)) {
            return redirect()->back()->with('success', trans('message.livraison.ModepaiementsOk', ['result' => var_dump($result)]));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.Modepaiementsfailed'));
        }
        
    }



    /**
    * Archivage d'une livraison
    *
    * @param integer  /  id de la livraison
    * @return Redirect
    **/
    public function archiver($id)
    {
        if ($this->domaine->archiver($id)) {
            return redirect()->back()->with('success', trans('message.livraison.archivageOk'));
        }else{
            $message = $this->domaine->getMessage();
            return redirect()->back()->with('status', $message);
        }
    }


}
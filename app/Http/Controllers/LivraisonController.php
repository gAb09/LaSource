<?php

namespace App\Http\Controllers;

use App\Domaines\LivraisonDomaine;
use App\Domaines\PanierDomaine as Panier;
use App\Domaines\ProducteurDomaine as Producteur;
use App\Domaines\RelaisDomaine as Relaiss;
use App\Http\Requests\LivraisonRequest;
use App\Http\Requests\PanierForLivraisonRequest;
use App\Http\Requests\RelaissForLivraisonRequest;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;

class LivraisonController extends Controller
{
    protected $domaine;
    protected $panier;
    protected $producteur;
    protected $relaiss;
    
    public function __construct(LivraisonDomaine $domaine, Panier $panier, Producteur $producteur, Relaiss $relaiss)
    {
        $this->domaine = $domaine;
        $this->panier = $panier;
        $this->producteur = $producteur;
        $this->relaiss = $relaiss;
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
                // return dd('store');
        // return dd($request->all());
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

        $date_titrepage = $model->date_livraison_enclair;

        $panierschoisis = $this->panier->paniersChoisis($id);
        // dd($panierschoisis);

        $relaiss = $this->relaiss->ListForLivraisonEdit($id);
        // dd($relaiss);

        return view('livraison.createdit.edit')->with(compact('model','date_titrepage', 'paniers', 'panierschoisis', 'relaiss' ));
    }


    public function update($id, LivraisonRequest $request)
    {
        // return dd($request->all());

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


    public function getComboDatesLivraison($valeur)
    {
        $data = $this->domaine->getComboDatesLivraison($valeur);
        return response()->json($data);
    }


    /**
    * Obtention des infos pour constituer la liste des paniers liés à cette livraison.
    * ToDo : Méthode de ce controleur où de PanierController ? Ou encore ProducteurController ?
    *
    * @param integer $panier_id
    * @return Object View
    **/
    public function listPaniers($livraison_id)
    {
        $model = $this->domaine->findFirst($livraison_id, 'id');

        $paniers = $this->panier->listPaniers($livraison_id);
        $titre_page = trans('titrepage.livraison.listPaniers', ['date' => $model->date_livraison_enclair]);

        return view('livraison.modales.listPaniers')->with(compact('model', 'paniers', 'titre_page'));
    }


    public function syncPaniers($livraison_id, PanierForLivraisonRequest $request)
    {
        $result = $this->domaine->SyncPaniers($livraison_id, $request->except('_token'));
        if (!empty($result)) {
            return redirect()->back()->with('success', trans('message.livraison.syncPaniersOk', ['result' => var_dump($result)]));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.syncPaniersfailed'));
        }
        
    }

    public function detachPanier($livraison, $panier)
    {
        // dd("detach panier $panier de $livraison");
        $this->domaine->detachPanier($livraison, $panier);
        return redirect()->action('LivraisonController@edit', ['livraison' => $livraison]);
    }

    /**
    * Obtention des infos pour constituer la liste des producteurs liés à un des paniers de cette livraison.
    * ToDo : Méthode de ce controleur où de PanierController ? Ou encore ProducteurController ?
    *
    * @param integer $panier_id
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

    public function syncRelaiss($livraison_id, Request $request)
    {
        // dd($request->get('is_retired'));

        $result = $this->domaine->SyncRelaiss($livraison_id, $request->except('_token'));
        if (!empty($result)) {
            return redirect()->back()->with('success', trans('message.livraison.syncOk', ['result' => var_dump($result)]));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.syncfailed'));
        }
        
    }


}
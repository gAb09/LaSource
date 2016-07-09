<?php

namespace App\Http\Controllers;

use App\Domaines\LivraisonDomaine as Livraison;
use App\Domaines\PanierDomaine as Panier;
use App\Domaines\ProducteurDomaine as Producteur;
use App\Http\Requests\LivraisonRequest;

use Illuminate\Http\Request;
use App\Http\Requests;

class LivraisonController extends Controller
{
    protected $domaine;
    protected $panier;
    protected $producteur;
    
    public function __construct(livraison $domaine, Panier $panier, Producteur $producteur)
    {
        $this->domaine = $domaine;
        $this->panier = $panier;
        $this->producteur = $producteur;
    }


    public function index()
    {
        $items = $this->domaine->index();

        return view('livraison.index')->with(compact('items'));
    }


    public function create()
    {
        $item = $this->domaine->create();
        $date_titrepage = "En création";

        return view('livraison.create')->with(compact('item', 'date_titrepage'));
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
    	$item = $this->domaine->edit($id);
        // return dd($item);
        $date_titrepage = $item->livraisonEnClair;
        $paniers = $this->panier->listPaniers($id);

        return view('livraison.edit')->with(compact('item','date_titrepage', 'paniers' ));
    }


    public function update($id, LivraisonRequest $request)
    {
        return dd($request->all());

        if($this->domaine->update($id, $request)){
            return redirect()->route('livraison.index')->with('success', trans('message.livraison.updateOk'));
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
    * Obtention des infos pour constituer la liste des paniers liés à cette livraison.
    * ToDo : Méthode de ce controleur où de PanierController ? Ou encore ProducteurController ?
    *
    * @param integer $panier_id
    * @return Object View
    **/
    public function listPaniers($livraison_id)
    {
        // dd('listPaniers');
        $item = $this->domaine->findFirst('id', $livraison_id);
        $item->livraisonEnClair = $item->date_livraison->formatLocalized('%A %e %B %Y');
        // dd($item);
        $paniers = $this->panier->listPaniers($livraison_id);
        $titre_page = trans('titrepage.livraison.listPaniers', ['date' => $item->livraisonEnClair]);

        return view('livraison.modales.listPaniers')->with(compact('item', 'paniers', 'titre_page'));
    }


    public function syncPaniers($livraison, Request $request)
    {
        // dd($request->input('resultat'));
        $this->domaine->syncPaniers($livraison, $request->input('resultat'));
        return redirect()->back();
    }

    public function detachPanier($livraison, $panier)
    {
        $this->domaine->detachPanier($livraison, $panier);
        return redirect()->back();
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
        $panier = $this->panier->findFirst('id', $panier_id);
        $producteurs = $this->producteur->listProducteursForPanier($panier_id);
        $titre_page = trans('titrepage.panier.choixproducteurs', ['panier_nomcourt' => $panier->nom_court]);
        return view('livraison.modales.listProducteursForPanier')->with(compact('panier_id', 'producteurs', 'titre_page'));
    }



}
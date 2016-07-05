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
    private $domaine;
    private $paniers;
    private $producteurs;
    
    public function __construct(livraison $domaine, Panier $paniers, Producteur $producteurs)
    {
        $this->domaine = $domaine;
        $this->paniers = $paniers;
        $this->producteurs = $producteurs;
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
        $paniers = $this->paniers->choixPaniers($id);

        return view('livraison.edit')->with(compact('item','date_titrepage', 'paniers', 'producteurs' ));
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

    public function choixProducteurs($id)
    {
        $datas = $this->producteurs->choixProducteurs($id);
        $producteurs = $datas['producteurs'];
        $titre_page = trans('titrepage.livraison.choixproducteurs', ['panier' => $datas['titre_page']]);;
        return view('livraison.ModalChoixProducteurs')->with(compact('producteurs', 'titre_page'));
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

}
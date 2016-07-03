<?php

namespace App\Http\Controllers;

use App\Domaines\LivraisonDomaine as Livraison;
use App\Domaines\PanierDomaine as Panier;
use App\Http\Requests\LivraisonRequest;

use Illuminate\Http\Request;
use App\Http\Requests;

class LivraisonController extends Controller
{
    private $livraison;
    private $paniers;
    
    public function __construct(livraison $livraison, Panier $paniers)
    {
        $this->livraison = $livraison;
        $this->paniers = $paniers;
    }


    public function index()
    {
        $items = $this->livraison->index();

        return view('livraison.index')->with(compact('items'));
    }


    public function create()
    {
        $item = $this->livraison->create();
        $paniers = $this->paniers->choixPaniers($item->id);

        return view('livraison.create')->with(compact('item', 'paniers'));
    }


    public function store(LivraisonRequest $request)
    {
                // return dd('store');
                return dd($request->all());

        if($this->livraison->store($request)){
            return redirect()->route('livraison.index')->with('success', trans('message.livraison.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.storefailed'));
        }
    }


    public function edit($id)
    {
    	$item = $this->livraison->edit($id);
        // return dd($item);
        $date_titrepage = $item->livraisonEnClair;
        $paniers = $this->paniers->choixPaniers($item->id);

        return view('livraison.edit')->with(compact('item','date_titrepage', 'paniers' ));
    }


    public function update($id, LivraisonRequest $request)
    {
                 // return dd('update');
               return dd($request->all());

        if($this->livraison->update($id, $request)){
            return redirect()->route('livraison.index')->with('success', trans('message.livraison.updateOk'));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.updatefailed'));
        }
    }


    public function destroy($id)
    {        
        return dd('Faut-il permettre la suppression ??');
        if($this->livraison->destroy($id)){
            return redirect()->route('livraison.index')->with('success', trans('message.livraison.deleteOk'));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.deletefailed'));
        }

    }

}
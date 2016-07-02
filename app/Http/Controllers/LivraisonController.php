<?php

namespace App\Http\Controllers;

use App\Domaines\LivraisonDomaine as Domaine;
use App\Domaines\PanierDomaine as Panier;
use App\Http\Requests\LivraisonRequest;

use Illuminate\Http\Request;
use App\Http\Requests;

class LivraisonController extends Controller
{
    private $domaine;
    private $paniers;
    
    public function __construct(Domaine $domaine, Panier $paniers)
    {
        $this->domaine = $domaine;
        $this->paniers = $paniers;
    }


    public function index()
    {
        $items = $this->domaine->index();

        return view('livraison.index')->with(compact('items'));
    }


    public function create()
    {
        $item = $this->domaine->create();
        $paniers = $this->paniers->choixPaniers();

        return view('livraison.create')->with(compact('item', 'paniers'));
    }


    public function store(LivraisonRequest $request)
    {
                // return dd('store');
                // return dd($request->all());

        if($this->domaine->store($request)){
            return redirect()->route('livraison.index')->with('success', trans('message.livraison.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.storefailed'));
        }
    }


    public function edit($id)
    {
    	$item = $this->domaine->edit($id);
        $date_titrepage = $item->livraisonEnClair;
        $paniers = $this->paniers->choixPaniers();

        return view('livraison.edit')->with(compact('item','date_titrepage', 'paniers' ));
    }

// 
    public function update($id, LivraisonRequest $request)
    {
                 // return dd('update');
               // return dd($request->all());

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

}
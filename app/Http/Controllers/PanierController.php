<?php

namespace App\Http\Controllers;

use App\Domaines\PanierDomaine as Domaine;
use App\Http\Requests\PanierRequest;

use Illuminate\Http\Request;
use App\Http\Requests;

class PanierController extends Controller
{
    private $domaine;
    
    public function __construct(Domaine $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
        $items = $this->domaine->all();
        return view('panier.index')->with(compact('items'));
    }


    public function create()
    {
        $item =  $this->domaine->newModel();
        return view('panier.create')->with(compact('item'));
    }


    public function store(PanierRequest $request)
    {
        if($this->domaine->store($request)){
            return redirect()->route('panier.index')->with('success', trans('message.panier.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.panier.storefailed'));
        }
    }


    public function edit($id)
    {
    	$item = $this->domaine->findFirst('id', $id);
    	return view('panier.edit')->with(compact('item'));
    }


    public function update($id, PanierRequest $request)
    {
        if($this->domaine->update($id, $request)){
            return redirect()->route('panier.index')->with('success', trans('message.panier.updateOk'));
        }else{
            return redirect()->back()->with('status', trans('message.panier.updatefailed'));
        }
    }


    public function destroy($id)
    {        
        if($this->domaine->destroy($id)){
            return redirect()->route('panier.index')->with('success', trans('message.panier.deleteOk'));
        }else{
            return redirect()->back()->with('status', trans('message.panier.deletefailed'));
        }

    }


    public function syncProducteurs($panier, Request $request)
    {
        // dd($panier);
        // dd('syncProducteurs');
        // dd($request->input('resultat'));
        $this->domaine->PanierSyncProducteurs($panier, $request->input('resultat'));
        return redirect()->back();
    }
}
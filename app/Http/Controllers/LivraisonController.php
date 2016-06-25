<?php

namespace App\Http\Controllers;

use App\Domaines\LivraisonDomaine as Domaine;
use App\Http\Requests\LivraisonRequest;
use Gab\Helpers\gabHelpers;

use Illuminate\Http\Request;
use App\Http\Requests;

class LivraisonController extends Controller
{
    private $domaine;
    
    public function __construct(Domaine $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
        $items = $this->domaine->index();
        $items->each(function ($item, $key) {
            if($key = 'date_paiement'){
                $item->paiement = gabHelpers::DatesFrlongue($item->date_paiement);
            }
            if($key = 'date_cloture'){
                $item->cloture = gabHelpers::DatesFrlongue($item->date_paiement);
            }
            if($key = 'date_livraison'){
                $item->livraison = gabHelpers::DatesFrlongue($item->date_paiement);
            }
        });

        return view('livraison.index')->with(compact('items'));
    }


    public function create()
    {
        $item =  $this->domaine->newModel();
        return view('livraison.create')->with(compact('item'));
    }


    public function store(LivraisonRequest $request)
    {
        if($this->domaine->store($request)){
            return redirect()->route('livraison.index')->with('success', trans('message.livraison.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.storefailed'));
        }
    }


    public function edit($id)
    {
    	$item = $this->domaine->findFirst('id', $id);
    	return view('livraison.form')->with(compact('item'));
    }


    public function update($id, LivraisonRequest $request)
    {
        if($this->domaine->update($id, $request)){
            return redirect()->route('livraison.index')->with('success', trans('message.livraison.updateOk'));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.updatefailed'));
        }
    }


    public function destroy($id)
    {        
        if($this->domaine->destroy($id)){
            return redirect()->route('livraison.index')->with('success', trans('message.livraison.deleteOk'));
        }else{
            return redirect()->back()->with('status', trans('message.livraison.deletefailed'));
        }

    }


}
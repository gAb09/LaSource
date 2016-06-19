<?php

namespace App\Http\Controllers;

use App\Domaines\ProducteurDomaine as Domaine;
use App\Http\Requests\ProducteurRequest;

use Illuminate\Http\Request;
use App\Http\Requests;

class ProducteurController extends Controller
{
    private $domaine;
    
    public function __construct(Domaine $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
        $items = $this->domaine->all();
        $titre_page = 'Les producteurs';

        return view('producteur.index')->with(compact('titre_page', 'items'));
    }


    public function create()
    {
        $item =  $this->domaine->newModel();
        $titre_page = 'Création d’un producteur';

        return view('producteur.create')->with(compact('titre_page', 'item'));
    }


    public function store(ProducteurRequest $request)
    {
        if($this->domaine->store($request)){
            return redirect()->route('producteur.index')->with('success', trans('message.producteur.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.producteur.storefailed'));
        }
    }


    public function edit($id)
    {
    	$item = $this->domaine->findFirst('id', $id);
    	$titre_page = 'Edition du producteur “'.$item->exploitation.'”';

    	return view('producteur.edit')->with(compact('item', 'titre_page'));
    }


    public function update($id, ProducteurRequest $request)
    {
        if($this->domaine->update($id, $request)){
            return redirect()->route('producteur.index')->with('success', trans('message.producteur.updateOk'));
        }else{
            return redirect()->back()->with('status', trans('message.producteur.updatefailed'));
        }
    }


    public function destroy($id)
    {        
        if($this->domaine->destroy($id)){
            return redirect()->route('producteur.index')->with('success', trans('message.producteur.deleteOk'));
        }else{
            return redirect()->back()->with('status', trans('message.producteur.deletefailed'));
        }

    }


}
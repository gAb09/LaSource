<?php

namespace App\Http\Controllers;

use App\Domaines\ProducteurDomaine as Domaine;
use App\Http\Requests\ProducteurRequest;
use App\Http\Controllers\getDeletedTrait;


use Illuminate\Http\Request;
use App\Http\Requests;

class ProducteurController extends Controller
{
    
    public function __construct(Domaine $domaine, Request $request)
    {
        $this->domaine = $domaine;
        $this->request = $request;
        $this->domaine_name = $this->domaine->getDomaineName();
    }



    public function create()
    {
        $model =  $this->domaine->getCurrentModel();
        return view('producteur.create')->with(compact('model'));
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
    	$model = $this->domaine->findFirstWithTrashed($id);
    	return view('producteur.edit')->with(compact('model'));
    }



    public function update($id, ProducteurRequest $request)
    {
        if($this->domaine->update($id, $request)){
            return redirect()->route('producteur.index')->with('success', trans('message.producteur.updateOk'));
        }else{
            $message = $this->domaine->getMessage();
            return redirect()->back()->with('status', $message);
        }
    }



    public function destroy($id)
    {        
        if($this->domaine->destroyAfterVerif($id)){
            return redirect()->route('producteur.index')->with('success', trans('message.producteur.deleteOk'));
        }else{
            $message = $this->domaine->getMessage();
            return redirect()->back()->with('status', $message);
        }
    }

}
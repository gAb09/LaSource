<?php

namespace App\Http\Controllers;

use App\Domaines\ProducteurDomaine as Producteur;
use App\Http\Requests\ProducteurRequest;

use Illuminate\Http\Request;
use App\Http\Requests;

class ProducteurController extends Controller
{
    private $domaine;
    
    public function __construct(Producteur $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
        $models = $this->domaine->all('rang');
        return view('producteur.index')->with(compact('models'));
    }


    public function create()
    {
        $model =  $this->domaine->newModel();
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
    	$model = $this->domaine->findFirst('id', $id);
    	return view('producteur.edit')->with(compact('model'));
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

    public function getDeleted()
    {
        $models = $this->domaine->getDeleted();
        return view('producteur.trashed')->with(['models' => $models, 'trashed' => 'trashed']);
    }

    public function setRangs(Request $request)
    {
        return $this->domaine->setRangs($request);
    }


}
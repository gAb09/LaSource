<?php

namespace App\Http\Controllers;

use App\Domaines\ProducteurDomaine as Producteur;
use App\Http\Requests\ProducteurRequest;
use App\Http\Controllers\getDeletedTrait;
use App\Http\Controllers\setRangsTrait;


use Illuminate\Http\Request;
use App\Http\Requests;

class ProducteurController extends Controller
{
    use getDeletedTrait, setRangsTrait;

    private $domaine;
    private $modelName;
    
    public function __construct(Producteur $domaine)
    {
        $this->domaine = $domaine;
        $this->modelName = 'producteur';
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
    	$model = $this->domaine->findFirst($id);
    	return view('producteur.edit')->with(compact('model'));
    }


    public function update($id, ProducteurRequest $request)
    {
        $resultat = ($this->domaine->update($id, $request));

        if($resultat){
            if (is_string($resultat)) {
                return redirect()->back()->with('status', $resultat);
            }else{
                return redirect()->route('producteur.index')->with('success', trans('message.producteur.updateOk'));
            }
        }else{
            return redirect()->back()->with('status', trans('message.producteur.updatefailed'));
        }
    }


    public function destroy($id)
    {        
        $resultat = ($this->domaine->destroy($id));

        if($resultat){
            if (is_string($resultat)) {
                return redirect()->back()->with('status', $resultat);
            }else{
                return redirect()->route('producteur.index')->with('success', trans('message.producteur.deleteOk'));
            }
        }else{
            return redirect()->back()->with('status', trans('message.producteur.deletefailed'));
        }

    }

}
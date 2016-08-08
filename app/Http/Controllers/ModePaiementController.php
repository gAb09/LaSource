<?php

namespace App\Http\Controllers;

use App\Domaines\ModePaiementDomaine as Domaine;
use App\Http\Requests\ModePaiementRequest;
use App\Http\Controllers\getDeletedTrait;
use App\Http\Controllers\setRangsTrait;

use Illuminate\Http\Request;
use App\Http\Requests;

class ModePaiementController extends Controller
{
    use getDeletedTrait, setRangsTrait;

    private $domaine;
    
    public function __construct(Domaine $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
        $models = $this->domaine->all('rang');
        return view('modepaiement.index')->with(compact('models'));
    }


    public function create()
    {
        $model =  $this->domaine->newModel();
        return view('modepaiement.create')->with(compact('model'));
    }


    public function store(ModePaiementRequest $request)
    {
        if($this->domaine->store($request)){
            return redirect()->route('modepaiement.index')->with('success', trans('message.modepaiement.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.modepaiement.storefailed'));
        }
    }


    public function edit($id)
    {
    	$model = $this->domaine->findFirst('id', $id);
        return view('modepaiement.edit')->with(compact('model'));
    }


    public function update($id, ModePaiementRequest $request)
    {
        $resultat = ($this->domaine->update($id, $request));

        if($resultat){
            if (is_string($resultat)) {
                return redirect()->back()->with('status', $resultat);
            }else{
                return redirect()->route('modepaiement.index')->with('success', trans('message.modepaiement.updateOk'));
            }
        }else{
            return redirect()->back()->with('status', trans('message.modepaiement.updatefailed'));
        }
    }


    public function destroy($id)
    {     
        $resultat = ($this->domaine->destroy($id));

        if($resultat){
            if (is_string($resultat)) {
                return redirect()->back()->with('status', $resultat);
            }else{
                return redirect()->route('modepaiement.index')->with('success', trans('message.modepaiement.deleteOk'));
            }
        }else{
            return redirect()->back()->with('status', trans('message.modepaiement.deletefailed'));
        }

    }

}
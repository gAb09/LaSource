<?php

namespace App\Http\Controllers;

use App\Domaines\ModePaiementDomaine as Domaine;
use App\Http\Requests\ModePaiementRequest;
use Gab\Helpers\gabHelpers;

use Illuminate\Http\Request;
use App\Http\Requests;

class ModePaiementController extends Controller
{
    private $domaine;
    
    public function __construct(Domaine $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
        $models = $this->domaine->index();

        return view('modepaiement.index')->with(compact('models'));
    }


    public function create()
    {
        $model =  $this->domaine->newModel();

        return view('modepaiement.create')->with(compact('model'));
    }


    public function store(ModePaiementRequest $request)
    {
                // return dd($request->all());

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
                // return dd($request->all());

        if($this->domaine->update($id, $request)){
            return redirect()->route('modepaiement.index')->with('success', trans('message.modepaiement.updateOk'));
        }else{
            return redirect()->back()->with('status', trans('message.modepaiement.updatefailed'));
        }
    }


    public function destroy($id)
    {        
        if($this->domaine->destroy($id)){
            return redirect()->route('modepaiement.index')->with('success', trans('message.modepaiement.deleteOk'));
        }else{
            return redirect()->back()->with('status', trans('message.modepaiement.deletefailed'));
        }

    }

    public function getDeleted()
    {
        $models = $this->domaine->getDeleted();
        return view('modepaiement.trashed')->with(compact('models', 'trashed'));
    }

    public function setRangs(Request $request)
    {
        return $this->domaine->setRangs($request);
    }


}
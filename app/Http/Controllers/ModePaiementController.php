<?php

namespace App\Http\Controllers;

use App\Domaines\ModePaiementDomaine as Domaine;
use App\Http\Requests\ModePaiementRequest;
use App\Http\Controllers\getDeletedTrait;

use Illuminate\Http\Request;
use App\Http\Requests;

class ModePaiementController extends Controller
{
    use getDeletedTrait;

    
    public function __construct(Domaine $domaine)
    {
        $this->domaine = $domaine;
        $this->domaine_name = $this->domaine->getDomaineName();
    }


    public function create()
    {
        $model =  $this->domaine->getCurrentModel();
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
    	$model = $this->domaine->findFirst($id);
        return view('modepaiement.edit')->with(compact('model'));
    }


    public function update($id, ModePaiementRequest $request)
    {
        if($this->domaine->update($id, $request)){
            return redirect()->route('modepaiement.index')->with('success', trans('message.modepaiement.updateOk'));
        }else{
            $message = $this->domaine->getMessage();
            return redirect()->back()->with('status', $message);
        }
    }


    public function destroy($id)
    {
        if($this->domaine->destroy($id)){
            return redirect()->route('modepaiement.index')->with('success', trans('message.modepaiement.deleteOk'));
        }else{
            $message = $this->domaine->getMessage();
            return redirect()->back()->with('status', $message);
        }
    }

}
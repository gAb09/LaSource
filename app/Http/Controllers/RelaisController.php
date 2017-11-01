<?php

namespace App\Http\Controllers;

use App\Domaines\RelaisDomaine as Domaine;
use App\Domaines\IndisponibiliteDomaine as Indisponibilite;
use App\Http\Requests\RelaisRequest;
use App\Http\Controllers\getDeletedTrait;
use App\Http\Controllers\handleIndisponibilitiesChangesTrait;

use Illuminate\Http\Request;
use App\Http\Requests;

class RelaisController extends Controller
{
    use handleIndisponibilitiesChangesTrait;


    public function __construct(Domaine $domaine, Request $request, Indisponibilite $indisponibilite)
    {
        $this->domaine = $domaine;
        $this->request = $request;
        $this->indisponibilite = $indisponibilite;
        $this->domaine_name = $this->domaine->getDomaineName();
    }



    public function create()
    {
        $model =  $this->domaine->getCurrentModel();
        return view('relais.create')->with(compact('model'));
    }


    public function store(RelaisRequest $request)
    {
        if($this->domaine->store($request)){
            return redirect()->route('relais.index')->with('success', trans('message.relais.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.relais.storefailed'));
        }
    }


    public function edit($id)
    {
    	$model = $this->domaine->findFirstWithTrashed($id);
    	return view('relais.edit')->with(compact('model'));
    }


    public function update($id, RelaisRequest $request)
    {
        if($this->domaine->updateAfterVerif($id, $request)){
            return redirect()->route('relais.index')->with('success', trans('message.relais.updateOk'));
        }else{
            $message = $this->domaine->getMessage();
            return redirect()->back()->with('status', $message);
        }
    }



    public function destroy($id)
    {
        if($this->domaine->destroyAfterVerif($id)){
            return redirect()->route('relais.index')->with('success', trans('message.relais.deleteOk'));
        }else{
            $message = $this->domaine->getMessage();
            return redirect()->back()->with('status', $message);
        }
    }

}
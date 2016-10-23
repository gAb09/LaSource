<?php

namespace App\Http\Controllers;

use App\Domaines\RelaisDomaine as Domaine;
use App\Domaines\IndisponibiliteDomaine as Indisponibilite;
use App\Http\Requests\RelaisRequest;
use App\Http\Controllers\getDeletedTrait;

use Illuminate\Http\Request;
use App\Http\Requests;

class RelaisController extends Controller
{
    use getDeletedTrait;


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
    	$model = $this->domaine->findFirst($id);
    	return view('relais.edit')->with(compact('model'));
    }


    public function update($id, RelaisRequest $request)
    {
        if($this->domaine->update($id, $request)){
            return redirect()->route('relais.index')->with('success', trans('message.relais.updateOk'));
        }else{
            $message = $this->domaine->getErrorMessage();
            return redirect()->back()->with('status', $message);
        }
    }



    public function destroy($id)
    {
        if($this->domaine->destroy($id)){
            return redirect()->route('relais.index')->with('success', trans('message.relais.deleteOk'));
        }else{
            $message = $this->domaine->getErrorMessage();
            return redirect()->back()->with('status', $message);
        }
    }



    /**
    * ??????????????????
    *
    * @param .??????????????
    * @return ?????????????
    **/
    public function handleIndisponibilitiesChanges($relais_id, Request $request)
    {
        // return dd($request->all());
        \DB::beginTransaction();

        foreach ($request->get('livraison_id') as $livraison_id => $action) {
            if ($action == 'attach') {
                $this->domaine->attachToLivraisons($relais_id, $livraison_id);
            }
            if ($action == 'detach') {
                $this->domaine->detachFromLivraisons($relais_id, $livraison_id);
            }
            if ($action == 'reported') {

            }
        }

        $request = \Session::get('initialContext.request');
        $success_message = \Session::get('initialContext.success_message');

        if ( \DB::statement($request) ) {
            \DB::commit();
            $message = $success_message.'<br />Les modifications éventuelles demandées ont été apportées aux livraisons.';
            return redirect($this->getUrlInitiale())->with('success', $message);
        }else{
            \DB::rollBack();
            $message = 'Un problème est survenu aucune modifications n’ont été apportées, ni à l’indisponibilité, ni aux livraisons.<br />Veuillez réessayer et contacter le Ouaibmestre si l’erreur persiste';
            return redirect($this->getUrlInitiale())->with('status', $mesage);
        }
    }



}
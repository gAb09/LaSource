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
        $items = $this->domaine->index();

        return view('modepaiement.index')->with(compact('items'));
    }


    public function create()
    {
        $item =  $this->domaine->newModel();

        return view('modepaiement.create')->with(compact('item'));
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
    	$item = $this->domaine->findFirst('id', $id);

        return view('modepaiement.edit')->with(compact('item'));
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


}
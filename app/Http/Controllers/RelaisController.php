<?php

namespace App\Http\Controllers;

use App\Domaines\RelaisDomaine as Domaine;
use App\Http\Requests\RelaisRequest;

use Illuminate\Http\Request;
use App\Http\Requests;

class RelaisController extends Controller
{
    private $domaine;
    
    public function __construct(Domaine $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
    	$items = $this->domaine->all();
    	return view('relais.index')->with(compact('items'));
    }


    public function create()
    {
        $item =  $this->domaine->newModel();

        return view('relais.create')->with(compact('item'));
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
    	$item = $this->domaine->findFirst('id', $id);

    	return view('relais.edit')->with(compact('item'));
    }


    public function update($id, RelaisRequest $request)
    {
        if($this->domaine->update($id, $request)){
            return redirect()->route('relais.index')->with('success', trans('message.relais.updateOk'));
        }else{
            return redirect()->back()->with('status', trans('message.relais.updatefailed'));
        }
    }

    public function destroy($id)
    {        
        if($this->domaine->destroy($id)){
            return redirect()->route('relais.index')->with('success', trans('message.relais.deleteOk'));
        }else{
            return redirect()->back()->with('status', trans('message.relais.deletefailed'));
        }

    }


}
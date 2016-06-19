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
    	$relaiss = $this->domaine->allActifs();
    	$titre_page = 'Les relais';

    	return view('relais.index')->with(compact('relaiss', 'titre_page'));
    }


    public function edit($id)
    {
    	$relais = $this->domaine->FindFirst('id', $id);
    	$titre_page = 'Edition du relais “'.$relais->nom.'”';

    	return view('relais.edit')->with(compact('relais', 'titre_page'));
    }


    public function update($id)
    {
    	return "update : relais n° $id";
        // $relais = $this->domaine->FindFirst('id', $id);
    	// $message = "???";

    	// return view('relais.index')->with(compact('message'));
    }

}
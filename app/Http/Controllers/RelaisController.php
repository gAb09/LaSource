<?php

namespace App\Http\Controllers;

use App\Models\Relais;

use Illuminate\Http\Request;
use App\Http\Requests;

class RelaisController extends Controller
{
    public function index()
    {
    	$relaiss = Relais::where('is_actif', 1)->get();
    	$titre_page = 'Les relais';

    	return view('relais.index')->with(compact('relaiss', 'titre_page'));
    }


    public function edit($id)
    {
    	$relais = Relais::where('id', $id)->first();
    	$titre_page = 'Edition du relais “'.$relais->nom.'”';

    	return view('relais.edit')->with(compact('relais', 'titre_page'));
    }


    public function update($id)
    {
    	return "update : relais n° $id";
    	// $relais = Relais::where('', $id)->first();
    	// $message = "???";

    	// return view('relais.index')->with(compact('message'));
    }

}
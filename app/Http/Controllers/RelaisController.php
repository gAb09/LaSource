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
}

<?php

namespace App\Http\Controllers;

use App\Domaines\CommandeDomaine as Domaine;
// use App\Http\Requests\CommandeRequest;
use App\Http\Controllers\getDeletedTrait;

use Illuminate\Http\Request;
use App\Http\Requests;

class CommandeController extends Controller
{
    
    public function __construct(Domaine $domaine, Request $request)
    {
        $this->domaine = $domaine;
        $this->request = $request;
        $this->domaine_name = $this->domaine->getDomaineName();
    }


    public function index()
    {
        $models = $this->domaine->index();
        return view('commande.index')->with(compact('models'));
    }



}
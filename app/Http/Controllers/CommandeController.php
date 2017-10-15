<?php

namespace App\Http\Controllers;

use App\Domaines\CommandeDomaine as Domaine;
use App\Http\Controllers\getDeletedTrait;
use App\Domaines\LivraisonDomaine;

use Illuminate\Http\Request;
use App\Http\Requests;

class CommandeController extends Controller
{
    
    public function __construct(Domaine $domaine, LivraisonDomaine $livraisonD, Request $request)
    {
        $this->domaine = $domaine;
        $this->livraisonD = $livraisonD;
        $this->request = $request;
        $this->domaine_name = $this->domaine->getDomaineName();
    }


    public function index($pages=5)
    {
        $models = $this->domaine->index($pages);
        return view('commande.index')->with(compact('models'));
    }

    public function create()
    {
        $livraison_id = $this->request->livraison_id;
        $livraison = $this->livraisonD->creationCommande($livraison_id);
        $model =  $this->domaine->getCurrentModel();
        return view('commande.create')->with(compact('model', 'livraison'));
    }

    public function store(Request $request)
    {
        return dd($request->all());
    }



}
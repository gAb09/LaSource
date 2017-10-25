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
        $result = $this->domaine->store($request);
        if( !is_integer($result) ){
            if ($result instanceof \Exception) {
                $e_message = "<br />".$result->getMessage();
            }else{
                $e_message = "";
            }
            $message = trans('message.commande.storefailed').$e_message;
            return redirect()->back()->with('status', $message);
        }else{
            return redirect()->back()->with('success', trans_choice('message.commande.storeOk', $result, ['count' => $result]));
        }
    }
}
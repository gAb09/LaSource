<?php

namespace App\Http\Controllers;

use App\Domaines\CommandeDomaine as Domaine;
use App\Http\Controllers\getDeletedTrait;
use App\Domaines\LivraisonDomaine;
use App\Http\Requests\CommandeRequest;

use Illuminate\Http\Request;
use App\Http\Requests;

class CommandeController extends Controller
{

    /**
     * undocumented function
     *
     * @return void
     **/
    public function __construct(Domaine $domaine, LivraisonDomaine $livraisonD, Request $request)
    {
        $this->domaine = $domaine;
        $this->livraisonD = $livraisonD;
        $this->request = $request;
        $this->domaine_name = $this->domaine->getDomaineName();
    }


    /**
     * undocumented function
     *
     * @return void
     **/
    public function index($pages=5)
    {
        $models = $this->domaine->index($pages);
        return view('commande.index')->with(compact('models'));
    }


    /**
     * Solliciter le domaine pour persister une(des) commande(s).
     * Gérer les messages d'erreur selon le résultat fourni.
     *
     * @param Illuminate\Http\Request $request 
     *
     * @return View
     **/
    public function store(Request $request)
    {
         // return dd($request->all());
        $result = $this->domaine->store($request);
        if( !is_integer($result) ){
            if ($result instanceof \Exception) {
                $e_message = "<br />".$result->getMessage();
            }else{
                $e_message = $this->domaine->getMessage();
            }
            $message = trans('message.commande.storefailed').$e_message;
            return redirect()->back()->with('status', $message)->withInput();
        }else if($result == 0) {
            return redirect()->back()->with('status', trans('message.commande.storeAllNull'))->withInput();
        }else{
            return redirect()->back()->with('success', trans_choice('message.commande.storeOk', $result, ['count' => $result]))->withInput();
        }
    }


    /**
     * undocumented function
     *
     * @return void
     **/
    public function edit($id)
    {
        $datas = $this->domaine->edit($id);

        $commande = $datas['commande'];
        $livraison = $datas['livraison'];
        $modespaiement = $datas['modespaiement'];
        $relaiss = $datas['relaiss'];


        return view('espace_client.une_livraison_ouverte')->with(compact('commande', 'livraison', 'modespaiement', 'relaiss'));
    }

    /**
     * undocumented function
     * Si toutes les quantités sont à 0 => delete ??
     * Si pas de modifications => ???
     *
     * @return void
     **/
    function update($id, Request $request)
    {
        $result = $this->domaine->update($id, $request);
        if( !is_integer($result) ){
            if ($result instanceof \Exception) {
                $e_message = "<br />".$result->getMessage();
            }else{
                $e_message = $this->domaine->getMessage();
            }
            $message = trans('message.commande.storefailed').$e_message;
            return redirect()->back()->with('status', $message)->withInput();
        }else if($result == 0) {
            return redirect()->back()->with('status', trans('message.commande.storeOneNull'))->withInput();
        }else{
            return redirect()->back()->with('success', trans_choice('message.commande.storeOk', $result, ['count' => $result]))->withInput();
        }
    }


    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    function archiver()
    {
        return dd('archivage à implémenter ??');
    }

     /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
     public function updateStatut($id)
     {
        return ['statut' => true, 'txt' => $id];
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function toggleBooleanProperty($property, $id)
    {
        $reponse = $this->domaine->toggleBooleanProperty($property, $id);
        return $reponse;
    }



}
<?php

namespace App\Http\Controllers;

use App\Domaines\FermetureDomaine as Fermeture;
use App\Domaines\Relais;
use App\Http\Requests\FermetureRequest;

use Illuminate\Http\Request;

class FermetureController extends Controller
{
    private $domaine;
    private $entity;
    private $domainesPath = 'App\\Domaines\\';
    
    public function __construct(Fermeture $domaine)
    {
        $this->domaine = $domaine;
    }


    public function index()
    {
        $models = $this->domaine->all('date_debut');
        return view('fermeture.index')->with(compact('models'));
    }


    public function store(Request $request)
    {
        if (!$this->domaine->store($request)) {
            return redirect()->back()->with( 'status', trans('message.fermeture.storefailed').trans('message.bug.transmis') );
        }

        $url_depart_ajout_fermeture = \Session::get('url_depart_ajout_fermeture');
        \Session::forget('url_depart_ajout_fermeture');
        return redirect($url_depart_ajout_fermeture)->with( 'success', trans('message.fermeture.storeOk') );
    }



    public function destroy($id)
    {     
        if($this->domaine->destroy($id)){
            if (is_string($resultat)) {
                return redirect()->back()->with('status', $resultat);
            }else{
                return redirect()->route('modepaiement.index')->with('success', trans('message.modepaiement.deleteOk'));
            }
        }else{
            return redirect()->back()->with('status', trans('message.modepaiement.deletefailed'));
        }
    }



}
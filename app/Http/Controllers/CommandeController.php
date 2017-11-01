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
        }else if($result == 0) {
            return redirect()->back()->with('status', trans('message.commande.storeNul'));
        }else{
            return redirect()->back()->with('success', trans_choice('message.commande.storeOk', $result, ['count' => $result]));
        }
    }


    public function edit($id)
    {
        $datas = $this->domaine->edit($id);

        $commande = $datas['commande'];
        $livraison = $datas['livraison'];
        $modespaiement = $datas['modespaiement'];
        $relaiss = $datas['relaiss'];
        $model = $datas['model'];


        return view('espace_client.une_livraison_ouverte')->with(compact('model', 'commande', 'livraison', 'modespaiement', 'relaiss'));
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    function update($id, Request $request)
    {
        return dd($request->except('_token', '_method'));
    }

}
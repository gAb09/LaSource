<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;

use App\Domaines\DashboardDomaine;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DashboardDomaine $domaineD)
    {
        $this->domaine = $domaineD;
    }


    /**
     * Le controller va recevoir une collection de livraisons, en fait une collection de collections de 4 angles de vue différents d'une même livraison :
     * – l'angle “livraison pure” (plutôt destinée au gestionnaire),
     * – l'angle “commande” (traitant plutôt du client),
     * – l'angle “producteur” (plutôt destinée au producteur),
     * – l'angle relais (plutôt destinée au relais).
     *
     * @return void
     */
    public function Main()
    {
        $collections = $this->domaine->getallCollectionsForDashboard();
        if($collections == false){
            // return dd($this->domaine);
            return view('dashboard.main')->with('message', $this->domaine->getMessage());
        }
        return view('dashboard.main')->with(compact('collections'));

    }


    // public function sendMailLivraisonsOuvertes($params, $datas, $vue){
    //     $envoi = Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $params) {
    //         $m->to($params['address']);
    //         $m->subject($params['subject']);
    //     });
    //     if($envoi){
    //         return redirect()->action('Auth\AuthController@showLoginForm')->with('success', trans('mails.sent'));
    //     }else{
    //         // TO_DO
    //         return redirect()->action('ContactController@Contact');
    //     }
    // }



}
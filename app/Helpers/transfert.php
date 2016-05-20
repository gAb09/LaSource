<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\User;
use App\ClientOld;
use Mail;


trait Transfert
{
    /*
    |--------------------------------------------------------------------------
    | Transfert d'un utilisateur
    |--------------------------------------------------------------------------
    |
    | Si l'utilisateur n'est pas authentifié avec la nouvelle procédure, 
    | c'est peut-être parcequ'il n'a pas encore été transféré.
    | On va donc 
    | 1) chercher à authentifier avec l'ancienne procédure, 
    | 2) si ok, gérer le tranfert en envisageant tous les dysfonctionnement possibles et ouvrir une transaction,
    | 3) si ok contrôler la bonne exécution du transfert (en faisant un test via la nouvelle procédure) et commit ou rollback la transaction,
    | 4) si ok authentifier l'utilisateur.
    | 
    */


    /**
     * 0) TransfertOK : transfert effectué.
     * 1) OldLoginFailed : Non identifié (login ne match pas).
     * 2) OldUserInconnu : Inconnu (login + mail ne match pas).
     * 3) OldAuthFailed : Non authentifié (Ancienne procédure à échoué, transfert interrompu).
     * 4) TransfertFailed : Problème en cours de transfert (Test nouvelle procédure à échoué, rollback transaction => transfert non effectué).
     *
     * @return void
     */
    private $statut = '';


    /**
    * Traitement du transfert.
    *
    * @param  \Illuminate\Http\Request  $request, $throttles
    * @return \Illuminate\Http\Response
    */
    private function HandleTransfert($request, $throttles){

        //Est-ce que le pseudo match un ancien login ?
        return $this->TryOldLoginMatch($request, $throttles);
    }


    /**
    * Si le pseudo fourni n'est pas trouvé dans l'ancienne base (champs “login_client“) :
    * – on place le statut à “OldLoginFailed“
    * – on demande à l'utilisater son email pour savoir comment poursuivre la procédure.
    * 
    * @param  \Illuminate\Http\Request
    * @return \View ou void
    */
    private function TryOldLoginMatch($request, $throttles)
    {
        $clientOld = ClientOld::where('login_client', $request->input("pseudo"))->first();

        if(empty($clientOld)) {
            $this->SetOldLoginFailed($request);

            return $this->askForMail();
        }
        return $this->tryOldAuthentication($clientOld, $request, $throttles);
    }


    /**
    * Gère le statut pour le statut dans le cas "OldLoginFailed" .
    *
    * @param  \Illuminate\Http\Request
    */
    private function SetOldLoginFailed($request)
    {
        $this->statut = 'OldLoginFailed';
        \Session::flash('transfert.message', 'Nous n\'avons pas trouvé le pseudo “'.$request->input('pseudo').'”.');
    }


    /**
    * Présente au client un formulaire pour saisir son mail.
    *
    * @return View
    */
    private function askForMail(){
        return view('auth.transfert.askForMailForm');
    }


    /**
    * On vérifie si l'adresse mail fournie est valide.
    * Si non on passe en statut "OldUserInconnu".
    * Si oui on poursuit le processus selon le statut actuel du transfert.
    *
    * @param  \Illuminate\Http\Request - Model $clientOld
    * @return \Illuminate\Http\RedirectResponse
    */
    public function ControlOldMail(Request $request){
     if(empty($clientOld = ClientOld::where('mail', $request->input('email'))->first())) {
        return $this->HandleOldUserInconnu($clientOld, $request);
    }else{
        return $this->HandleCurrentStatut($clientOld, $request);
    }
}


    /**
    * Envoi du mail rapport au OuaibMaistre
    * Redirige sur le formulaire d'enregistrement
    *
    * @param  \Illuminate\Http\Request - Model $clientOld
    * @return \Illuminate\Http\RedirectResponse
    */
    private function HandleOldUserInconnu($clientOld, $request)
    {
        \Session::flash('transfert.message', 'L’adresse “'.$request->input("email").'” n\'a pu être trouvée. Nous n\'avons donc pas pu vous identifier');
        $this->statut = "OldUserInconnu";

        $param['subject'] = $this->statut.' - '.$request->input("email");
        $datas[] = $request;
        $this->SendMailOM($param, $datas);

        return redirect()->action('Auth\AuthController@showRegistrationForm');
    }



    /**
    * Enchaîne la procédure selon le statut actuel du transfert.
    *
    * @param  \Illuminate\Http\Request - Model $clientOld
    * @return \Illuminate\Http\Response
    */
    public function HandleCurrentStatut($clientOld, $request){
        $function = 'Handle'.$this->statut;
        return $this->{$function}($clientOld, $request);
    }


    /**
    * Envoi du mail rapport au OuaibMaistre.
    * Envoi au client d'un mail contenant son ancien login.
    * Redirige sur la page de login.
    *
    * @param  \Illuminate\Http\Request - Model $clientOld
    * @return \Illuminate\Http\Response ???????
    */
    private function HandleOldLoginFailed($clientOld, $request)
    {
        $param['subject'] = $this->statut;
        $datas[] = $request->input('email');
        $datas[] = $request;
        $this->SendMailOM($param, $datas);

        $param['address'] = $request->input("email");
        $param['subject'] = 'Paniers La Source : rappel de votre login';
        $datas['clientOld'] = $clientOld;
        return $this->SendMailClient($param, $datas, 'auth.transfert.emails.clients.OldLoginFailed');
    }


    /**
    *
    * @param  \Illuminate\Http\Request  $request, $clientOld
    */
    private function SendMailOM($param, $datas, $vue = 'auth.transfert.emails.mailToOM'){
        Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $param) {
            $m->to = env('MAIL_SENDER_ADRESS');
            $m->subject($param['subject']);
        });
    }

    /**
    *
    * @param  \Illuminate\Http\Request  $request, $clientOld
    */
    public function SendMailClient($param, $datas, $vue){
        $envoi = Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $param) {
            $m->to($param['address']);
            $m->subject($param['subject']);
        });

        if($envoi){
            \Session::flash('transfert.message', 'Un mail vient de vous être envoyé');
            return redirect()->action('Auth\AuthController@showLoginForm');
        }else{
            return redirect()->action('ContactController@Contact');
        }
    }



    /**
    * Essai de l'ancien mode d'authentification.
    *
    * @param  \Illuminate\Http\Request - Model $clientOld - $throttles
    * @return \Illuminate\Http\Response
    */
    private function tryOldAuthentication($clientOld, $request, $throttles){
        $password_coded = $this->codageOLD($request->input('password'));

        if ($password_coded == $clientOld->mdp_client) 
        { 
          return $this->DoTransfert($request, $throttles);
      }

      $this->SetOldAuthFailed($request);

      return $this->askForMail();
  }


    /**
    * Gère le statut pour le statut dans le cas "OldAuthFailed" .
    *
    * @param  \Illuminate\Http\Request
    */
    private function SetOldAuthFailed($request)
    {
        $this->statut = 'OldAuthFailed';
        \Session::flash('transfert.message', 'Nous n\'avons pas pu vous authentifier avec vos anciens identifiants');
    }


    /**
    * Envoi du mail rapport au OuaibMaistre.
    * Envoi au client d'un mail contenant son ancien login.
    * Redirige sur la page de login.
    *
    * @param  \Illuminate\Http\Request - Model $clientOld
    * @return \Illuminate\Http\Response ???????
    */
    private function HandleOldAuthFailed($clientOld, $request)
    {
        $param['subject'] = $this->statut.' - '.$request->input('pseudo');
        $datas[] = $request->input('email');
        $datas[] = $request;
        $this->SendMailOM($param, $datas);

        $param['address'] = $request->input("email");
        $param['subject'] = 'Paniers La Source : rappel de vos identifiants';
        $datas['clientOld'] = $clientOld;
        $datas['mdp_tempo'] = $this->getMdpTempo();
        return $this->SendMailClient($param, $datas, 'auth.transfert.emails.clients.OldAuthFailed');
    }


    /**
    * ???????????????????.
    * ????????????????? 
    *
    * @param  \Illuminate\Http\Request  $request ??????
    * @return \Illuminate\Http\Response ????????
    */
    private function getMdpTempo(){
        return 'mdp_tempo';
    }


    /**
    * ???????????????????.
    * ????????????????? 
    *
    * @param  \Illuminate\Http\Request  $request ??????
    * @return \Illuminate\Http\Response ????????
    */
    private function DoTransfert($request, $throttles){
        dd('DoTransfert');//CTRL

        if (1 == 1) 
        { 
            return $this->handleUserWasAuthenticated($request, $throttles);;
        }
        return dd('DoTransfert à échoué');
    }


    /**
    * ???????????????????.
    * ????????????????? 
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    private function InitTransfert($request, $clientOld){

        if (1 == 1) 
        { 
            return true;
        }
        return false;
    }




    /*
    |--------------------------------------------------------------------------
    | Hachage SHA-1 - héritage de la première version
    |--------------------------------------------------------------------------
    |
    | Si l'utilisateur n'est pas authentifié avec la nouvelle procédure, 
    | c'est peut-être parcequ'il n'a pas encore été transféré.
    | On va donc 
    | 1) chercher à authentifier avec l'ancienne procédure, 
    | 2) le cas échéant, gérer le tranfert en envisageant tous les dysfonctionnement possibles,
    | 3) contrôler sa bonne exécution,
    | 4) authentifier l'utilisateur.
    | 
    */
    private function codageOLD($password)
    {
        $prefix = 'dkklqlsdqs7567hkj';
        $sufix = 'kjlklsq7065chKg65';
        return sha1($prefix.$password.$sufix);
    }

}

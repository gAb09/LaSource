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

        private $client_old;

        private $request;

        private $throttles; // A conserver ??

        private $message = '';


    /**
    * Traitement du transfert.
    *
    * @param  \Illuminate\Http\Request  $request, $throttles
    * @return \Illuminate\Http\Response
    */
    private function HandleTransfert($request, $throttles){
        var_dump('HandleTransfert');  //CTRL
        $this->clientOld = ClientOld::where('login_client', $request->input("pseudo"))->first();
        $this->request = $request;
        $this->throttles = $throttles;

        //Est-ce que le pseudo match un ancien login ?
        if(empty($this->clientOld)) {
           return $this->TryOldLogin();
       }

        //Est-ce que l'ancienne authentification fonctionne ?
       return $this->tryOldAuthentication($request, $throttles, $clientOld);

   }


    /**
    * ????????????????.
    *
    * @return \Illuminate\Http\Response
    */
    private function TryOldLogin()
    {
        var_dump('TryOldLogin'); //CTRL

        $this->message = 'Nous n\'avons pas trouvé le pseudo “'.$this->request->input('pseudo').'”';

        return $this->getOldMail();
    }

    /**
    * On présente au client un formulaire de saisie de son mail.
    *
    * @return View
    */
    private function getOldMail(){
        var_dump('getOldMail');  //CTRL
        return view('auth.transfert.getOldMailForm')->with('message_transfert', $this->message);
    }

    /**
    * On vérifie si l'adresse mail fournie est valide.
    * Si oui on poursuit le processus selon le statut actuel du transfert.
    * Si non on passe en statut OldUserInconnu.
    *
    * @return \Illuminate\Http\Response
    */
    public function ControlOldMail(Request $request){
       if(empty($clientOld = ClientOld::where('mail', $request->input("email"))->first())) {
        return $this->OldUserInconnu($request);
    }else{
        return $this->OldLoginFailed($clientOld);
    }
}

    /**
    * Si mail inconnu, on fait une nouvelle inscription + set statut = OldUserInconnu.
    *
    * @return \Illuminate\Http\Response ???????
    */
    private function OldUserInconnu($request)
    {
        var_dump('mailNotFound : OldUserInconnu');  //CTRL
        \Session::flash('message_transfert', 'Nous n\'avons pas pu vous identifier');

        $param['subject'] = "OldUserInconnu";
        $datas[] = $request->input('email');
        $datas[] = $request;
        $this->SendMailOM($param, $datas);

        return redirect()->action('Auth\AuthController@showRegistrationForm');
    }

    /**
    * ????????????????.
    *
    * @return \Illuminate\Http\Response
    */
    private function OldLoginFailed($clientOld)
    {
        $param['subject'] = "OldLoginFailed : $clientOld->prenom $clientOld->nom";
        $datas['clientOld'] = $clientOld;
        $this->SendMailOM($param, $datas);

        $param['address'] = $clientOld->mail;
        $param['subject'] = 'OldLoginFailed';
        $datas['clientOld'] = $clientOld;
        $vue = 'auth.transfert.emails.OldLoginFailedToClient';

        return $this->SendMailClient($param, $datas, $vue);
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
            \Session::flash('message_transfert', 'Un mail vient de vous être envoyé');
            return redirect()->action('Auth\AuthController@showLoginForm');
        }else{
            return redirect()->action('ContactController@Contact');
        }
    }





    /**
    * Essai de l'ancien mode d'authentification.
    * Auparavant on testera 
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    private function tryOldAuthentication($request, $throttles, $clientOld){
        $password_coded = $this->codageOLD($request->input('password'));

        if ($password_coded == $clientOld->mdp_client) 
        { 
          return $this->DoTransfert($request, $clientOld, $throttles);
      }
      return $this->OldAuthFailed();
    }


    /**
    * ???????????????????.
    * ????????????????? 
    *
    * @param  \Illuminate\Http\Request  $request ??????
    * @return \Illuminate\Http\Response ????????
    */
    private function DoTransfert($request, $clientOld, $throttles){
        var_dump('DoTransfert');//CTRL

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
    * @param  \Illuminate\Http\Request  $request ??????
    * @return \Illuminate\Http\Response ????????
    */
    private function OldAuthFailed($request, $clientOld, $throttles){
        dd('ni nouvelle ni ancienne');//CTRL
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

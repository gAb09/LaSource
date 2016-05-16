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

    private $statut_transfert = '';
/**
* Traitement du transfert.
*
* @param  \Illuminate\Http\Request  $request
* @return Boolean
*/
private function HandleTransfert($request, $throttles){
    var_dump('HandleTransfert');
// Est-ce que le pseudo match un ancien login ?

    if(empty($clientOld = ClientOld::where('login_client', $request->input("pseudo"))->first())) {
     var_dump('oldPseudoFailed');
     return $this->TryIdentificationByOldMail($request, $clientOld);
 }

 return $this->tryOldAuthentication($request, $throttles, $clientOld);

 if ($clientOld = ClientOld::where('login_client', $credentials['pseudo'])->first()) {
    dd($clientOld);

}else{
    dd('ni nouvelle ni ancienne');
    return $this->sendFailedLoginResponse($request);
}



// if(!$this->InitTransfert($request, $clientOld)){
//     return $this->sendFailedLoginResponse($request);
// }

// if(!$this->DoTransfert($request, $clientOld)){
//     return $this->sendFailedLoginResponse($request);
// }

}


/**
* Traitement du transfert lorsqu'on a pas trouvé le pseudo dans l'ancienne base.
* On demande au client de saisir son mail pour tenter de l'identifier.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
private function TryIdentificationByOldMail($request, $clientOld){
    var_dump('TryIdentificationByOldMail');
    return view('auth.transfert.TryIdentificationByOldMailForm')->with('pseudo', $request->input('pseudo'));
}

/**
* Si mail connu on envoie par mail au client son pseudo + nouveau mot de passe.
*
* @return \Illuminate\Http\Response ???????
*/
public function OldLoginFailed(Request $request)
{
    if(empty($clientOld = ClientOld::where('mail', $request->input("email"))->first())) {
        return $this->OldUserInconnu();
    }else{
        var_dump($clientOld->mail);

        $this->statut_transfert = 'OldLoginFailed';

        $this->SendMailOuaibmaistre($request, $clientOld);

        return $this->SendMailClient($request, $clientOld);
    }
}

/**
* Si mail inconnu aussi, on fait une nouvelle inscription + set statut_transfert = OldUserInconnu.
*
* @return \Illuminate\Http\Response ???????
*/
public function OldUserInconnu()
{
    var_dump('mailNotFound : OldUserInconnu');

    $this->statut_transfert = 'OldUserInconnu';

    $this->SendMailOuaibmaistre(null, null);

    \Session::flash('statut', $this->statut_transfert);

    return redirect()->action('Auth\AuthController@showRegistrationForm');
}

/**
*
* @param  \Illuminate\Http\Request  $request, $clientOld
*/
public function SendMailOuaibmaistre($request, $clientOld = null){
    $statut_transfert = $this->statut_transfert;
     // return view('auth.transfert.emails.mailOuaibmaistre')->with(compact('clientOld', 'statut_transfert')); //TEST MAIL
    $mail = Mail::send('auth.transfert.emails.mailOuaibmaistre', compact('clientOld', 'statut_transfert'), function ($m) use ($clientOld, $statut_transfert) {
        $m->to('lasource@confluence09.fr')->subject("$statut_transfert : $clientOld->nom");
    });

    return $mail;
}

/**
*
* @param  \Illuminate\Http\Request  $request, $clientOld
*/
public function SendMailClient($request, $clientOld = null){
    $mail = Mail::send('auth.transfert.emails.oldLoginFailed', ['clientOld' => $clientOld], function ($m) use ($clientOld) {
        $m->to($clientOld->mail, $clientOld->login_client)->subject('Your Reminder!');
    });

    if($mail){
        \Session::flash('message_mail', 'Un mail de confrmation vient de vous être envoyé');
        return redirect()->action('Auth\AuthController@showLoginForm');
    }else{
        return redirect()->action('ContactController@showContactForm');
    }
}


/**
* Essaie l'ancien mode d'authentification.
* Auparavant on testera 
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
private function tryOldAuthentication($request, $throttles, $clientOld){
    $password_coded = $this->codageOLD($request->input('password'));

    if ($password_coded == $clientOld->mdp_client) 
    { 
      return $this->handleUserWasAuthenticated($request, $throttles);
  }
}

// return $this->sendFailedLoginResponse($request);

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


/**
* ???????????????????.
* ????????????????? 
*
* @param  \Illuminate\Http\Request  $request ??????
* @return \Illuminate\Http\Response ????????
*/
private function DoTransfert($request, $clientOld){

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
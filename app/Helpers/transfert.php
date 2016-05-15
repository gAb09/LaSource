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
     * Traitement du transfert.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Boolean
     */
     private function HandleTransfert($request, $throttles){
        // Est-ce que le pseudo match un ancien login ?
        if(empty($clientOld = ClientOld::where('login_client', $request->input("pseudo"))->first())) {
            // var_dump($clientOld);
            return $this->DismatchOldPseudo($request);
        }

        if(!$this->tryOldAuthentication($request, $clientOld)){
            return $this->sendFailedLoginResponse($request);
        }

        if(!$this->InitTransfert($request, $clientOld)){
            return $this->sendFailedLoginResponse($request);
        }

        if(!$this->DoTransfert($request, $clientOld)){
            return $this->sendFailedLoginResponse($request);
        }

        return $this->handleUserWasAuthenticated($request, $throttles);
    }


     /**
     * Traitement du transfert lorsqu'on a pas trouvé ce pseudo dans l'ancienne base.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     private function DismatchOldPseudo($request){
        return view('auth.transfert.ResetOldloginForm')->with('pseudo', $request->input('pseudo'));
    }


     /**
     * Essaie l'ancien mode d'authentification.
     * Auparavant on testera 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     private function tryOldAuthentication($request, $clientOld){
        $password_coded = $this->codageOLD($request->input('password'));

        if ($password_coded == $clientOld->mdp_client) 
        { 
            return true;
        }
        return false;
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


     /**
     * ???????????????????.
     * ???????????????return dd(?? 
     *
     * @return \Illuminate\Http\Response ???????
     */
     public function ResetOldloginViaMail(Request $request)
     {
        if(empty($clientOld = ClientOld::where('mail', $request->input("email"))->first())) {
            dd('mailNotFound');
        }else{
            // dd($clientOld->mail);
            $retour = Mail::send('auth.emails.test', ['clientOld' => $clientOld], function ($m) use ($clientOld) {
                // $m->from(env('MAIL_SENDER_ADRESS'), env('MAIL_SENDER'));

                $m->to('gbom@club-internet.fr', $clientOld->login_client)->subject('Your Reminder!');
            });

            return $retour;
        }
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
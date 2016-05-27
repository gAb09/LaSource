<?php

namespace App\Http\Controllers\Transfert;

// use Illuminate\Http\Request;
use Mail;


trait TransfertTrait
{
    /*
    |--------------------------------------------------------------------------
    | Transfert d'un utilisateur
    |--------------------------------------------------------------------------
    |
    | Si l'utilisateur n'est pas authentifié avec la nouvelle procédure, on va : 
    | – Tester si le pseudo est connu dans la nouvelle base => utilisateur se trompe => ConnexionForm
    | – Tester si le pseudo est connu dans l'ancienne base
    |       NON => utilisateur se trompe ou inconnu  => ConnexionForm
    |       OUI => chercher à authentifier avec l'ancienne procédure 
    |           NON utilisateur se trompe ou inconnu  => ConnexionForm
    |           OUI     On lance le transfert, => EnCours
    |                   on le controle (en authentifiant via la nouvelle procédure) si NON => TransfertFailed
    |                   et on le valide => OK => Espace Client
    |
    | – Depuis le ConnexionForm l'utilisateur peut modifier sa saisie et réessayer 
    | ou demander le reset de ses identifiants via une adresse email.
    |       Si l'adresse est trouvée dans la nouvelle base => ResetNewCredentials
    |       SinonSi l'adresse est trouvée dans l'ancienne base => ResetOldCredentials + mail OM
    |       SinonSi l'adresse n'est pas trouvée du tout => OldUserInconnu => Inscription + mail OM
    |  
    */


    /*
     * Les STATUTS :
     * 0) AuthFailed : Utilisateur inconnu.
     * 1) ResetOldCredentials : Client a demandé la régénération de ses identifiants (OLD).
     * 2) OldUserInconnu : Inconnu (login + mail ne match pas).
     * 3) EnCours : transfert en cours, pas encore controlé (begin transaction).
     * 4) TransfertFailed : Problème en cours de transfert
     *    (Test nouvelle procédure à échoué, rollback transaction => transfert non effectué).
     * 5) OK : transfert terminé et validé (commit transaction).

     *
     * @return void
     */
    private $statut = '';



    /**
    * Traitement du pseudo.
    * – Si le pseudo fourni est trouvé dans la nouvelle base (champs “login_client“)
    *   c'est que le user se trompe => connexionForm.
    * – Si le pseudo fourni n'est pas trouvé dans l’ancienne base (champs “login_client“)
    *   c'est que le problème ne vient pas d'un transfert à effectuer => connexionForm.
    *   s'il est trouvé on tente l'ancienne authentification en lui passant le client_old trouvé.
    * 
    * @param  \Illuminate\Http\Request  $request, $throttles
    * @return \Illuminate\Http\Response
    */
    private function TryPseudo($request, $throttles)
    {
        if( !is_null( $this->PseudoInNewBDD($request) ) ){
            return $this->AuthFailed($request);
        }

        if( is_null( $clientOld = $this->PseudoInOldBDD($request) ) ) {
            return $this->AuthFailed($request);
        }else{
            return $this->tryOldAuthentication($clientOld, $request, $throttles);
        }
    }


    private function PseudoInNewBDD($request)
    {
        return $this->user->FindBy('pseudo', $request->input("pseudo"));
    }


     /**
    * Appelle le formulaire de connexion en mode "AuthFailed".
    *
    * @param  \Illuminate\Http\Request
    * @return \Illuminate\Http\Response
    */
     private function AuthFailed($request)
     {
        return redirect()->back()
        ->withInput($request->only($this->loginUsername(), 'remember'))
        ->with('alert.danger', trans('auth.failed'))
        ;
    }


    private function PseudoInOldBDD($request)
    {
        return $this->client_old->FindBy('login_client', $request->input("pseudo"));
    }


    /**
    * Ancien mode d'authentification.
    *
    * @param  \Illuminate\Http\Request - Model $clientOld - $throttles
    * @return \Illuminate\Http\Response
    */
    private function tryOldAuthentication($clientOld, $request, $throttles){
        $password_oldCoded = $this->oldCodage($request->input('password'));

        if ($password_oldCoded == $clientOld->mdp_client){
            return $this->DoTransfert($request, $throttles);
        }else{
            return $this->AuthFailed($request);
        }
    }


     /**
    * Gère l'assignation de statut.
    *
    * @param  string 
    */
     private function setStatut($statut)
     {
        $this->statut = $statut;
        \Session::put('transfert.statut', $statut);
    }


    /** ----------------------   A VOIR   -----------------------
    * Exécute le transfert avec vérification
    *
    * @param  \Illuminate\Http\Request
    * @return \Illuminate\Http\Response
    */
    private function DoTransfert($request, $throttles){
        dd('DoTransfert');//CTRL

        if (1 == 1) 
        { 
            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        return dd('DoTransfert à échoué');
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
    private function oldCodage($password)
    {
        $prefix = 'dkklqlsdqs7567hkj';
        $sufix = 'kjlklsq7065chKg65';
        return sha1($prefix.$password.$sufix);
    }














    /** ----------------------   A REVOIR   -----------------------
    * On vérifie si l'adresse mail fournie est connue.
    * Si non on passe en statut "OldUserInconnu".
    * Si oui on poursuit le processus selon le statut actuel du transfert.
    *
    * @param  \Illuminate\Http\Request - Model $clientOld
    * @return \Illuminate\Http\RedirectResponse
    */
    public function ControlOldMail(Request $request){
        $this->validate($request, ['email' => 'required|email']);

        if(empty($clientOld = ClientOld::where('mail', $request->input('email'))->first())) {
            return $this->HandleOldUserInconnu($clientOld, $request);
        }else{
            return $this->HandleCurrentStatut($clientOld, $request);
        }
    }


    /** ----------------------   A REVOIR   -----------------------
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





    /** ----------------------   A REVOIR   -----------------------
    * Envoi du mail rapport au OuaibMaistre.
    * Envoi au client d'un mail contenant son ancien login.
    * Redirige sur la page de login.
    *
    * @param  \Illuminate\Http\Request - Model $clientOld
    * @return \Illuminate\Http\Response ???????
    */
    public function HandleresetOldCredentials(Request $request){

        if(empty($clientOld = ClientOld::where('mail', $request->input('email'))->first())) {
            return $this->HandleOldUserInconnu($clientOld, $request);
        }else{
            $param['subject'] = $this->statut;
            $datas[] = $request->input('email');
            $datas[] = $request;
            $this->SendMailOM($param, $datas);

            $param['address'] = $request->input("email");
            $param['subject'] = 'Paniers La Source : Récupération de pseudo';
            $datas['clientOld'] = $clientOld;
            return $this->SendMailClient($param, $datas, 'auth.transfert.emails.clients.OldLoginFailed');
        }
    }


    /** ----------------------   A REVOIR   -----------------------
    *
    * @param  \Illuminate\Http\Request  $request, $clientOld
    */
    private function SendMailOM($param, $datas, $vue = 'auth.transfert.emails.mailToOM'){
        Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $param) {
            $m->to = env('MAIL_SENDER_ADRESS');
            $m->subject($param['subject']);
        });
    }

    /** ----------------------   A REVOIR   -----------------------
    *
    * @param  \Illuminate\Http\Request  $request, $clientOld
    */
    public function SendMailClient($param, $datas, $vue){
        $envoi = Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $param) {
            $m->to($param['address']);
            $m->subject($param['subject']);
        });

        if($envoi){
            return redirect()->action('Auth\AuthController@showLoginForm')->with('alert.success', trans('mails.sent'));
        }else{
            return redirect()->action('ContactController@Contact');
        }
    }
}

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
    |       SinonSi l'adresse n'est pas trouvée du tout => CompteIntrouvable => Inscription
    |  
    */


    /*
     * Les STATUTS :
     * 1) ResetOldCredentials : utilisateur a demandé la régénération de ses identifiants (OLD).
     * 2) CompteIntrouvable : utilisateur natcasesort(array)on reconnu (login + mail ne match pas).
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
    * – Si le pseudo fourni est trouvé dans la nouvelle base (users.pseudo)
    *   c'est que le user se trompe => connexionForm.
    * – Sinon si le pseudo fourni n'est pas trouvé dans l’ancienne base (paniers_clients.login_client)
    *   c'est que le problème ne vient pas d'un transfert à effectuer => connexionForm.
    *   s'il est trouvé on tente l'ancienne authentification en lui passant le client_old trouvé.
    * 
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    private function TryPseudo($request)
    {
        if( !is_null( $this->PseudoInNewBDD($request) ) ){
            return $this->AuthFailed($request);
        }

        if( is_null( $clientOld = $this->PseudoInOldBDD($request) ) ) {
            return $this->AuthFailed($request);
        }else{
            return $this->tryOldAuthentication($request, $clientOld);
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
    * @param  \Illuminate\Http\Request - Model $clientOld
    * @return \Illuminate\Http\Response
    */
    private function tryOldAuthentication($request, $clientOld){
        $password_oldCoded = $this->oldCodage($request->input('password'));

        if ($password_oldCoded == $clientOld->mdp_client){
            return $this->handleTransfert($clientOld);
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


    /** 
    * Exécute le transfert avec vérification
    *
    * @param  App\Models\ClientOld
    * @return \Illuminate\Http\Response
    */
    private function handleTransfert($clientOld){
        $this->setStatut('EnCours');

        dd('handleTransfert');//CTRL

        if ($this->tryTransfert($clientOld) == true) 
        {
            $this->setStatut('OK');
            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        return dd('handleTransfert à échoué');
    }


    /** 
    * Exécute le transfert avec vérification
    *
    * @param  \Illuminate\Http\Request
    * @return \Illuminate\Http\Response
    */
    private function tryTransfert($request){

        return ;
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


    /**
    *
    * @param  \Illuminate\Http\Request  $request, $clientOld
    */
    private function SendMailOuaibmaistre($param, $datas, $vue = 'auth.transfert.emails.Ouaibmaistre'){
        Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $param) {
            $m->to = env('MAIL_OM_ADRESS');
            $m->subject($param['subject']);
        });
    }


    /**
    *
    * @param  \Illuminate\Http\Request  $request, $clientOld
    */
    private function SendMailGestionnaire($param, $datas, $vue = 'auth.transfert.emails.Gestionnaire'){
        Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $param) {
            $m->to = env('MAIL_GEST_ADRESS');
            $m->subject($param['subject']);
        });
    }



    /**
    *
    * @param  \Illuminate\Http\Request  $request, $clientOld
    */
    public function SendMailClient($params, $datas, $vue){
        $envoi = Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $params) {
            $m->to($params['address']);
            $m->subject($params['subject']);
            $m->setBody($this->setBodyMailClientAfterInscription($params, $datas));
        });

        // if($envoi){
        //     return redirect()->action('Auth\AuthController@showLoginForm')->with('alert.success', trans('mails.sent'));
        // }else{
        //     return redirect()->action('ContactController@Contact');
        // }
    }

    /**
    * Constitue le corps du mail destiné au client après inscription.
    * @return  string
    */
    public function setBodyMailClientAfterInscription($params, $datas){
        $body = 'Bonjour '.$params['nomcomplet'].',<br />';
        $body .= 'Nous avons le plaisir de vous confirmer la validation de votre inscription <br />
        aux Paniers Bios d’Ariège, sur notre ';
        $body .= \Html::link('http://www.bioariege.fr', 'site Internet');
        $body .= '.<br />';
        $body .= '<br />';
        $body .= 'Pour tout renseignement sur ce service, vous pouvez nous contacter :<br />
        - par téléphone : 06 87 31 09 84<br />
        - par E-mail : ';
        $body .= \Html::mailto('paniers@bioariege.fr', 'paniers@bioariege.fr');
        $body .= '.<br />';
        $body .= '<br />';
        $body .= 'Nous vous remercions de votre confiance <br />
        et espérons que ce nouveau service vous apportera entière satisfaction.<br />
        Les Bios d’Ariège - CIVAM BIO 09<br />
        Signature ???';

        return $body;
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\Transfert\TransfertUserTrait;
use App\Domaines\UserDomaine as User;
use App\Domaines\ClientOldDomaine as ClientOld;


class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords, TransfertUserTrait;

    private $linkRequestView = 'auth.passwords.askMail';

    private $subject;

    private $broker;

    protected $redirectTo = 'espaceclient';



    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(User $user, ClientOld $client_old)
    {
        $this->middleware('guest');
        $this->user = $user;
        $this->client_old = $client_old;
        $this->subject = trans('passwords.reset_mail_subject');
    }


    /**
     * Change la configuration selon que l'on à affaire à un user ou un ClientOld.
     * Initialise et fournit le PasswordBroker à la méthode sendResetLinkEmail().
     * Si ni user, ni ClientOld on renvoir sur le formulaire de saisie du mail,
     * en proposant le lien d'inscription (réinscription).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function HandleSendingResetMail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        if($this->mailInNewBDD($request)){
            return $this->sendResetLinkEmail($request);
        }

        if($this->mailInOldBDD($request)){
            $this->SetStatut('resetOldCredentials');

            $param['subject'] = $this->statut.' - '.$request->input("email");
            $datas[] = $request;
            $this->SendMailOuaibmaistre($param, $datas);

            \Config::set("auth.defaults.passwords","clientOld");
            return $this->sendResetLinkEmail($request);
        }

        $this->SetStatut('CompteIntrouvable');

        return redirect()->back()
        ->withErrors(['email' => trans('passwords.mail_validation')])
        ->with('status', trans('transfert.compteintrouvable'))
        ;
    }


    /**
     * Recherche le mail dans la table users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function mailInNewBDD($request)
    {
        if( !empty( $this->user->FindBy('email', $request->input('email')) )  ){
            return true;
        }
        return false;
    }


    /**
     * Recherche le mail dans la table paniers_clients.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function mailInOldBDD($request)
    {
        if( !empty( $this->client_old->FindBy('email', $request->input('email')) ) ){
            return true;
        }
        return false;
    }


    /**
     * Surcharge de Illuminate\Foundation\Auth\ResetsPasswords.
     * Le passwordBroker n'est pas initialisé dans cette méthode,
     * mais initialisé et passé par la méthode  HandleSendingResetMail().
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $broker
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail($request)
    {
        $broker = $this->getBroker();

        $response = Password::broker($broker)->sendResetLink(
            $request->only('email'), $this->resetEmailBuilder()
            );

        switch ($response) {
            case Password::RESET_LINK_SENT:
            return $this->getSendResetLinkEmailSuccessResponse($response);

            case Password::INVALID_USER:
            default:
            return $this->getSendResetLinkEmailFailureResponse($response);
        }
    }


    /**
     * Surcharge de Illuminate\Foundation\Auth\ResetsPasswords.
     * 'success' remplace 'status'
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getSendResetLinkEmailSuccessResponse($response)
    {
        return redirect()->back()->with('success', trans($response));
    }


    /**
     * Surcharge de Illuminate\Foundation\Auth\ResetsPasswords.
     * 'success' remplace 'status'
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getResetSuccessResponse($response)
    {
        return redirect($this->redirectPath())->with('success', trans($response));
    }


    /**
     * Réponse de la route password/reset.
     * Aiguillage selon Users ou ClientOld.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function handleResetCredentials(Request $request, ClientOld $client_old)
    {
        if($this->mailInNewBDD($request)){
            return $this->reset($request);
        }

        if($this->mailInOldBDD($request)){
         \Config::set("auth.defaults.passwords","clientOld");
           // return $this->reset($request);
         return $this->resetOldCredentials($request, $client_old);
     }
     return redirect()->back()->with('status', trans('auth.failed'));
 }


    /**
     * Reset le mot de passe dans clientOld.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function resetOldCredentials($request, ClientOld $client_old)
    {
        $new_mdp = $request->input('password');
        $client_old = $client_old->FindBy('email', $request->input('email'));
        $client_old->mdp_client = $this->oldCodage($new_mdp);
        $client_old->save();
        return $this->handleTransfert($client_old);
    }


}

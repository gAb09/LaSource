<?php

namespace App\Http\Controllers\Auth;

use App\Domaines\UserDomaine as User;
use App\Models\User as UserModel;

use App\Models\Client;
use App\Domaines\ClientOldDomaine as ClientOld;
use App\Http\Controllers\Transfert\TransfertTrait;
use App\Http\Requests\InscriptionRequest;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins, TransfertTrait;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'espaceclient';

    protected $username = 'pseudo';

    protected $loginView = 'auth.connexionForm';

    protected $redirectAfterLogout = 'accueil';

    protected $registerView = 'client.register';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(User $user, ClientOld $client_old)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->statut = \Session::get('transfert_statut');
        $this->user = $user;
        $this->client_old = $client_old;

    }

    /**
     * Reprise de Illuminate\Foundation\Auth\AuthenticatesUsers.
     * + Recours à l'ancienne procédure d'authentification
     * avant de déclarer l'échec de la nouvelle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function connexion(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }


        // Si l'utilisateur n'est pas authentifié dans la nouvelle application, 
        // il faut voir s'il existait dans l'ancienne et pas encore transféré.
        return $this->tryOldPseudo($request);

    }


    /**
     * Handle an authentication attempt.
     * Redirige sur différentes pages d'accueil selon le rôle.
     *
     * @return Response
     */
    public function authenticated()
    {
        if (Auth::user()->role->id == 5){
            return redirect()->intended('dashboard');
        }
        if (Auth::user()->role->id == 10){
            return redirect()->intended('espaceclient');
        }
        if (Auth::user()->role->id == 1){
            return redirect()->intended('dashboard');
        }
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'pseudo' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            ]);
    }


    /**
     * Surcharge de Illuminate\Foundation\Auth\RegistersUsers.
     * Modification de la validation, recours à la classe InscriptionRequest.
     *
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(InscriptionRequest $request)
    {
        $this->HandleReinscriptionCases($request);

        Auth::guard($this->getGuard())->login($this->create($request->all()));

        \Session::forget('transfert_statut');

        $this->sendMailConfirmInscription($request);

        return redirect($this->redirectPath());
    }

    /**
     * Alerte le Ouaibmaistre par mail si il s'agit d'une réinscription,
     * suite à un transfert défectueux (CompteIntrouvable ou TransfertFailed).
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    protected function HandleReinscriptionCases($request)
    {
        $statut = \Session::get('transfert_statut');
        if( $statut == 'CompteIntrouvable' or $statut == 'TransfertFailed' ){
            $datas = $request->except('password', 'password_confirmation', 'token');
            $param['subject'] = $statut.' : '.$request->input('email');
            $this->SendMailOuaibmaistre($param, $datas);
        }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new UserModel;
        $user->pseudo = $data['pseudo'];
        $user->email = $data['email'];
        $user->role_id = 10;
        $user->password = bcrypt($data['password']);
        $user->save();

        $client = new Client;
        $client->user_id = $user->id;
        $client->prenom = $data['prenom'];
        $client->nom = $data['nom'];
        $client->ad1 = $data['ad1'];
        $client->ad2 = $data['ad2'];
        $client->cp = $data['cp'];
        $client->ville = $data['ville'];
        $client->telephone = $data['telephone'];
        $client->mobile = $data['mobile'];
        $client->save();
        
        return $user;

    }


    /**
     * Envoi d'un mail de confirmation au client, au gestionnaire et au Ouaibmaistre.
     *
     * @param  array  $data
     * @return User
     */
    protected function sendMailConfirmInscription($request)
    {
        $input = $request->input();

        $datasclient['nomcomplet'] = $input['prenom'].' '.$input['nom'];
        $params['address'] = $input['email'];
        $params['subject'] = "Paniers La Source : Confirmation d'inscription";
        $this->SendMailClient($params, $datasclient, 'auth.transfert.emails.ClientInscription');

        $params['subject'] = 'Confirmation d’inscription : '.$input['prenom'].' '.$input['nom'].' -- '.$input['email'];
        $datas['content'] = 'Confirmation d’inscription : '.$input['prenom'].' '.$input['nom'].' -- '.$input['email'];
        $this->SendMailGestionnaire($params, $datas);
        
        $datas['content'] = $request->input();
        $this->SendMailOuaibmaistre($params, $datas);

    }

}



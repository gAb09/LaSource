<?php

namespace App\Http\Controllers\Auth;

use App\Domaines\UserDomaine as User;
use App\Domaines\ClientOldDomaine as ClientOld;

use App\Http\Controllers\Transfert\TransfertTrait;
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


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(User $user, ClientOld $client_old)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->statut = \Session::get('transfert.statut');
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
        $this->setStatut('AuthFailed');
        return $this->TryPseudo($request, $throttles);

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
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm($oldPseudo = null)
    {
        $view = property_exists($this, 'loginView')
        ? $this->loginView : 'auth.connexionForm';

        if (view()->exists($view)) {
            return view($view)->with(compact('oldPseudo'));
        }

        return view('auth.login');
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'pseudo' => $data['pseudo'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]);
    }


    /**
     * Surcharge de Illuminate\Foundation\Auth\RegistersUsers
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm($compteinconnu = false)
    {
        if ($compteinconnu) {
            $this->setStatut('CompteInconnu');
            
            // $param['subject'] = $this->statut.' - '.$request->input("email");
            // $datas[] = $request;
            // $this->SendMailOM($param, $datas);
        }

        return view('auth.register')->with(compact('compteinconnu'));
    }


}



<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Client;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Surcharge de Illuminate\Foundation\Auth\AuthenticatesUsers.
     * + Recours à l'ancien mode d'authentification (tryOldAuthentication()) si échec de la nouvelle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logi(Request $request)
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

        // Si l'utilisateur n'était pas transféré on essaie avec l'ancienne authentification 
        var_dump(Auth::User());
        if ($this->tryOldAuthentication($request, $throttles)) {
            dd("Old OK");
            return $this->handleUserWasAuthenticated($request, $throttles);
        }else{
            dd("Old pas OK");
        }

       return $this->sendFailedLoginResponse($request);
    }

     /**
     * Surcharge de Illuminate\Foundation\Auth\AuthenticatesUsers.
     * Essaie l'ancien mode d'authentification (tryOldAuthentication()) si échec de la nouvelle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   private function tryOldAuthentication($request, $throttles){
            var_dump("tryAuthOld");

        //login_client existe ?
        if(!empty($client = Client::where('login_client', $request->input("pseudo"))->first())) {
             var_dump("login trouvé");
           var_dump($request->input());
            var_dump($client['attributes']);
            // tryAuthOldViaLogin();
            return false;
        }else{
            var_dump("pas de OldUser");
            return false;
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
            'pseudo' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Surcharge de Illuminate\Foundation\Auth\AuthenticatesUsers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);
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
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'pseudo';
    }

    /**
     * Surcharge de Surcharge de Illuminate\Foundation\Auth\AuthenticatesUsers\RegistersUsers
     * Création de compte assujettie à réponse à un mail de confirmation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        dd('register');

        Auth::guard($this->getGuard())->login($this->create($request->all()));

        return redirect($this->redirectPath());
    }


/* -------------------------------------------------------------------------------------
Hachage SHA-1 - héritage de la première version
--------------------------------------------------------------------------------------- */

function codageOLD($password)
    {
    $prefix = 'dkklqlsdqs7567hkj';
    $sufix = 'kjlklsq7065chKg65';
    $entree=$prefix.$entree.$sufix; 
    return sha1($entree);
    }

}

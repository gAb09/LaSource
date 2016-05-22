<?php

namespace App\Http\Controllers\Transfert;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class OldPasswordController extends Controller
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

    use ResetsPasswords;

    private $broker = 'clientOld';

    private $user = 'clientOld';

    private $subject = 'Paniers La Source : réinitialisation de mot de passe';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
    * Send a reset link to the given user.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function sendResetLinkEmail(Request $request)
    {dd('eee');
        $broker = $this->getBroker();

        $response = Password::broker($broker)->sendResetLink(
            $request->only('email'), $this->resetEmailBuilder()
            );

        switch ($response) {
            case Password::RESET_LINK_SENT:
            return dd($this->getSendResetLinkEmailSuccessResponse($response));

            case Password::INVALID_USER:
            default:
            return dd($this->getSendResetLinkEmailFailureResponse($response));
        }
    }


}

<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }


    public function Main()
    {
        $livraisons['A']['name'] = 'A';
        $livraisons['B']['name'] = 'B';
        $livraisons['C']['name'] = 'C';

        return view('dashboard.main')->with(compact('livraisons'));
    }

    public function composerMails()
    {
        return view('dashboard.partials.mails');
    }

    public function sendMailLivraisonsOuvertes($params, $datas, $vue){
        $envoi = Mail::send($vue, ['datas' => $datas], function ($m) use($datas, $params) {
            $m->to($params['address']);
            $m->subject($params['subject']);
        });
        if($envoi){
            return redirect()->action('Auth\AuthController@showLoginForm')->with('success', trans('mails.sent'));
        }else{
            // TO_DO
            return redirect()->action('ContactController@Contact');
        }
    }



}
<?php

namespace App\Http\Controllers;

use App\Client;

use App\Http\Requests;
use Illuminate\Http\Request;

class EspaceClientController extends Controller
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


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = \Auth::user();

        $user_id = $user->id;
        $client = Client::with('User')->where('user_id', $user_id)->first();

        return view('espaceclient')->with(compact('client', 'client'));
    }
}

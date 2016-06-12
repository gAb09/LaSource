<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;

use App\Http\Requests;
use Illuminate\Http\Request;

class ClientController extends Controller
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
    public function show(Request $request)
    {
        $user = \Auth::user();
        $user = $user->load('Client');
        // $user_id = $user->id;
        // $client = Client::with('User')->where('user_id', $user_id)->first();

        return view('espaceclient')->with(compact('user'));
    }
}

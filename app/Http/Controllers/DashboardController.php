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


}
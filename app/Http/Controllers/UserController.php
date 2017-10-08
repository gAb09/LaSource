<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
    	return 'Est-ce nécessaire pour le gestionnaire de gérer les users ??';
    }

    public function edit($id)
    {
        $model = User::findOrFail($id);
        return view('user.edit')->with(compact('model'));
    }




}

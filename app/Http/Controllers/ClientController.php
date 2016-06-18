<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Http\Requests\CoordonneesRequest;

use App\Http\Requests;
use App\Http\Requests\ClientRequest;
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


    public function espaceClient()
    {
        $item = \Auth::user();
        $item = $item->load('Client');

        return view('espaceclient')->with(compact('item'));
    }


    public function create()
    {
        $item =  new Client;
        $titre_page = 'Création d’un client';

        return view('client.create')->with(compact('titre_page', 'item'));
    }


    public function store(ClientRequest $request)
    {
        $item = new Client;
        $item->exploitation = $request->exploitation;
        $item->nom = $request->nom;
        $item->prenom = $request->prenom;
        $item->ad1 = $request->ad1;
        $item->ad2 = $request->ad2;
        $item->cp = $request->cp;
        $item->ville = $request->ville;
        $item->tel = $item->cleanTel($request->tel);
        $item->mobile = $item->cleanTel($request->mobile);
        $item->nompourpaniers = $request->nompourpaniers;
                // $item->is_actif = (isset($request->is_actif)?1:0); // ToDo ??
                // $item->email = $request->email; // ToDo

        if($item->save()){
            return redirect()->route('client.index')->with('success', 'Le client a bien été créé');
        }else{
            return redirect()->back()->with('status', 'Problème lors de la création');
        }

    }


    public function edit($id)
    {
        $item = User::with('client')->where('id', $id)->first();
        $titre_page = 'Modification de mes coordonnées';

        return view('client.edit')->with(compact('item', 'titre_page'));
    }


    public function update($id, CoordonneesRequest $request)
    {
        $item = Client::where('id', $id)->first();

        $item->exploitation = $request->exploitation;
        $item->nom = $request->nom;
        $item->prenom = $request->prenom;
        $item->ad1 = $request->ad1;
        $item->ad2 = $request->ad2;
        $item->cp = $request->cp;
        $item->ville = $request->ville;
        $item->tel = $item->cleanTel($request->tel);
        $item->mobile = $item->cleanTel($request->mobile);
        $item->nompourpaniers = $request->nompourpaniers;
        // $item->is_actif = (isset($request->is_actif)?1:0); // ToDo ??
        // $item->email = $request->email; // ToDo

        if($item->save()){
            return redirect()->route('espaceclient')->with('success', trans('message.client.updateOk'));
        }else{
            return redirect()->back()->with('status', trans('message.client.updatefailed'));
        }
    }

    public function destroy($id)
    {
        $item = Client::where('id', $id)->first();
        dd("ToDo : gérer suppression du user associé (id n° $id)"); // ToDo
        if($item->delete()){
            return redirect()->route('client.index')->with('success', trans('message.client.deleteOk'));
        }else{
            return redirect()->back()->with('status', trans('message.client.deletefailed'));
        }

    }


}
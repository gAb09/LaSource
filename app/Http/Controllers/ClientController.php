<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Http\Requests\CoordonneesRequest;

use App\Http\Requests;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use App\Domaines\ClientDomaine;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ClientDomaine $clientD)
    {
        $this->domaine = $clientD;
        // $this->middleware('auth');
    }


    public function index()
    {
        $models = $this->clientD->index();
        // return dd($models);
        return view('client.index')->with(compact('models'));
    }


    public function store(ClientRequest $request)
    {
        $model = new Client;
        $model->nom = $request->nom;
        $model->prenom = $request->prenom;
        $model->ad1 = $request->ad1;
        $model->ad2 = $request->ad2;
        $model->cp = $request->cp;
        $model->ville = $request->ville;
        $model->tel = $model->cleanTel($request->tel);
        $model->mobile = $model->cleanTel($request->mobile);
                // $model->is_actived = (isset($request->is_actived)?1:0); // ToDo ??
                // $model->email = $request->email; // ToDo

        if($model->save()){
            return redirect()->route('espaceclient')->with('success', trans('message.client.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.client.storefailed'));
        }

    }


    public function edit($id)
    {
        $model = Client::with('user')->where('id', $id)->first();
        return view('client.edit')->with(compact('model'));
    }


    public function update($id, CoordonneesRequest $request)
    {
        $model = Client::where('id', $id)->first();

        $model->nom = $request->nom;
        $model->prenom = $request->prenom;
        $model->ad1 = $request->ad1;
        $model->ad2 = $request->ad2;
        $model->cp = $request->cp;
        $model->ville = $request->ville;
        $model->tel = $model->cleanTel($request->tel);
        $model->mobile = $model->cleanTel($request->mobile);
        // $model->is_actived = (isset($request->is_actived)?1:0); // ToDo ??
        // $model->email = $request->email; // ToDo
// dd($model);
        if($model->save()){
            return redirect()->route('espaceclient')->with('success', trans('message.client.updateOk'));
        }else{
            return redirect()->back()->with('status', trans('message.client.updatefailed'));
        }
    }



    public function destroy($id)
    {
        $model = Client::where('id', $id)->first();
        dd("ToDo : gérer suppression du user associé (id n° $id)"); // ToDo
        if($model->delete()){
            return redirect()->route('client.index')->with('success', trans('message.client.deleteOk'));
        }else{
            return redirect()->back()->with('status', trans('message.client.deletefailed'));
        }

    }



    public function setPrefRelais(Request $request)
    {
        return $models = $this->domaine->setPrefRelais($request->id);
    }



    public function setPrefPaiement(Request $request)
    {
        return $models = $this->domaine->setPrefPaiement($request->id);
    }



    public function setRangs(Request $request)
    {
        return $this->domaine->setRangs($request);
    }


}
<?php

namespace App\Http\Controllers;

use App\Models\Producteur;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ProducteurRequest;

class ProducteurController extends Controller
{
    public function index()
    {
        $items = Producteur::all();
        $titre_page = 'Les producteurs';

        return view('producteur.index')->with(compact('titre_page', 'items'));
    }


    public function create()
    {
        $item =  new Producteur;
        $titre_page = 'Création d’un producteur';

        return view('producteur.create')->with(compact('titre_page', 'item'));
    }


    public function store(ProducteurRequest $request)
    {
        $item = new Producteur;
        $item->exploitation = $request->exploitation;
        $item->nom = $request->nom;
        $item->prenom = $request->prenom;
        $item->ad1 = $request->ad1;
        $item->ad2 = $request->ad2;
        $item->cp = $request->cp;
        $item->ville = $request->ville;
        $request->tel = str_replace('.', '', $request->tel);
        $request->tel = str_replace(' ', '', $request->tel);
        $item->tel = $request->tel;
        $request->mobile = str_replace('.', '', $request->mobile);
        $request->mobile = str_replace(' ', '', $request->mobile);
        $item->mobile = $request->mobile;
        $item->email = $request->email;
        $item->nompourpaniers = $request->nompourpaniers;
        $item->is_actif = (isset($request->is_actif)?1:0);
        if($item->save()){
            return redirect()->route('producteur.index')->with('success', trans('message.producteur.storeOk'));
        }else{
            return redirect()->back()->with('status', trans('message.producteur.storefailed'));
        }

    }


    public function edit($id)
    {
    	$item = producteur::where('id', $id)->first();
    	$titre_page = 'Edition du producteur “'.$item->exploitation.'”';

    	return view('producteur.edit')->with(compact('item', 'titre_page'));
    }


    public function update($id, ProducteurRequest $request)
    {
        // return dd($request->all());
    	// return "update : producteur n° $id";
    	$item = producteur::where('id', $id)->first();
        $item->exploitation = $request->exploitation;
        $item->nom = $request->nom;
        $item->prenom = $request->prenom;
        $item->ad1 = $request->ad1;
        $item->ad2 = $request->ad2;
        $item->cp = $request->cp;
        $item->ville = $request->ville;
        $request->tel = str_replace('.', '', $request->tel);
        $request->tel = str_replace(' ', '', $request->tel);
        $item->tel = $request->tel;
        $request->mobile = str_replace('.', '', $request->mobile);
        $request->mobile = str_replace(' ', '', $request->mobile);
        $item->mobile = $request->mobile;
        $item->email = $request->email;
        $item->nompourpaniers = $request->nompourpaniers;
        $item->is_actif = (isset($request->is_actif)?1:0);

        if($item->save()){
            return redirect()->route('producteur.index')->with('success', trans('message.producteur.updateOk'));
        }else{
            return redirect()->back()->with('status', trans('message.producteur.updatefailed'));
        }
    }

    public function destroy($id)
    {
        $item = producteur::where('id', $id)->first();
        
        if($item->delete()){
            return redirect()->route('producteur.index')->with('success', trans('message.producteur.deleteOk'));
        }else{
            return redirect()->back()->with('status', trans('message.producteur.deletefailed'));
        }

    }


}
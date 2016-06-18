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
        // $item = producteur::where('id', $id)->first();
        $titre_page = 'Création d’un producteur';
        $item =  new Producteur;

        return view('producteur.create')->with(compact('titre_page', 'item'));
    }


    public function store(ProducteurRequest $request)
    {
        $item = new Producteur;
                $item->id = $request->id;
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
                    return redirect()->route('producteur.index')->with('success', 'Le producteur a bien été créé');
                }else{
                    return redirect()->back()->with('status', 'Problème lors de la création');
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
                    return redirect()->route('producteur.index')->with('success', 'Le producteur a bien été créé');
                }else{
                    return redirect()->back()->with('status', 'Problème lors de la création');
                }
    }

    public function destroy($id)
    {
        $item = producteur::where('id', $id)->first();
        $item->delete();

        return redirect()->route('producteur.index');
    }


}
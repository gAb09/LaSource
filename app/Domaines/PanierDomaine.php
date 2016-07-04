<?php

namespace App\Domaines;

use App\Models\Panier;
use App\Domaines\Domaine;
use Illuminate\Http\Request;


class PanierDomaine extends Domaine
{
	protected $panier;

	public function __construct(){
		$this->panier = new Panier;
	}

	public function store($request){
		$this->handleRequest($request);

		return $this->panier->save();
	}

	public function update($id, $request){
		$this->panier = Panier::where('id', $id)->first();
		$this->handleRequest($request);

		return $this->panier->save();
	}


	private function handleRequest($request){
		$this->panier->nom = $request->nom;
		$this->panier->nom_court = $request->nom_court;
		$this->panier->famille = $request->famille;
		$this->panier->type = $request->type;
		$this->panier->idee = $request->idee;
		$this->panier->prix_commun = $request->prix_commun;
		$this->panier->is_actif = (isset($request->is_actif)?1:0);
		$this->panier->remarques = $request->remarques;
	}

	public function choixPaniers($id = null)
	{
		$items = $this->panier->with('Producteur', 'livraison')->where('is_actif', 1)->orderBy('type')->get();

		/* create */
		if ($id == null) { 
			return $items;
		}

		/* update */
		$items->each(function($item) use($id)
		{
			$livraisons = $item->livraison;
			if(!empty($livraisons))
			{
				$livraisons->each(function($livraison) use($id, $item)
				{
					if ( $livraison->id == $id)
					{
						$item->lied = "lied";
					}
				});
			}
		});
		return $items;
	}

	public function detachFromLivraison($panier, $livraison)
	{
		$item = Panier::find($panier);
		$item->livraison()->detach($livraison);
	}


}





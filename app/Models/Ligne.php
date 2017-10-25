<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ligne extends Model
{

	protected $fillable = ['panier_id', 'quantite', 'commande_id'];


	public function Commande()
	{
		return $this->belongsTo('App\Models\Commande');

	}

	public function Panier()
	{
		return $this->belongsTo('App\Models\Panier');
	}


}

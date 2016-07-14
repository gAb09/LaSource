<?php

namespace App\Models;

use App\Models\ModelTrait;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Livraison extends Model
{
    use SoftDeletes, ModelTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'date_paiement', 'date_cloture', 'date_livraison'];

    protected $appends = array('class_actif');

    public function Panier()
    {
        return $this->belongsToMany('App\Models\Panier')->withPivot('producteur', 'prix_livraison');
    }

    public function getDateClotureEnclairAttribute($value)
    {
        $value = $this->date_cloture;
        return $value->formatLocalized('%A %e %B %Y');
    }

    public function getDatePaiementEnclairAttribute($value)
    {
        $value = $this->date_paiement;
        return $value->formatLocalized('%A %e %B %Y');
    }

    public function getDateLivraisonEnclairAttribute($value)
    {
        $value = $this->date_livraison;
        return $value->formatLocalized('%A %e %B %Y');
    }

    public function getDateClotureDelaiAttribute($value)
    {
        $value = $this->date_cloture;
        $now = Carbon::now();
        Carbon::setLocale('fr');
        // return $value->diffForHumans($now, true);
        return $value->diffInDays($now, true);
    }

    public function getDatePaiementDelaiAttribute($value)
    {
        $value = $this->date_paiement;
        $now = Carbon::now();
        Carbon::setLocale('fr');
        // return $value->diffForHumans($now, true);
        return $value->diffInDays($now, true);
    }

    public function getDateLivraisonDelaiAttribute($value)
    {
        $value = $this->date_livraison;
        $now = Carbon::now();
        Carbon::setLocale('fr');
        // return $value->diffForHumans($now, true);
        return $value->diffInDays($now, true);
    }

}
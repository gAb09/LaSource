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

    protected $appends = array('class_actived', 'state');

    private $state = "L_CREATED";

    protected $guarded = [];



    public function Panier()
    {
        return $this->belongsToMany('App\Models\Panier')->withPivot('producteur', 'prix_livraison');
    }


    public function Relais()
    {
        return $this->belongsToMany('App\Models\Relais')->withPivot('motif');
    }


    public function Modepaiements()
    {
        return $this->belongsToMany('App\Models\ModePaiement')->withPivot('motif');
    }


    public function getDateClotureEnclairAttribute($value)
    {
        $value = $this->date_cloture;
        if (!is_null($value)) {
            return $value->formatLocalized('%A %e %B %Y');
        }
    }

    public function getDatePaiementEnclairAttribute($value)
    {
        $value = $this->date_paiement;
        if (!is_null($value)) {
            return $value->formatLocalized('%A %e %B %Y');
        }
    }

    public function getDateLivraisonEnclairAttribute($value)
    {
        $value = $this->date_livraison;
        if (!is_null($value)) {
            return $value->formatLocalized('%A %e %B %Y');
        }
    }

    public function getDateClotureDelaiAttribute($value)
    {
        $value = $this->date_cloture;
        $now = Carbon::now();
        Carbon::setLocale('fr');
        // return $value->diffForHumans($now, true);
        return $now->diffInDays($value, false);
    }

    public function getDatePaiementDelaiAttribute($value)
    {
        $value = $this->date_paiement;
        $now = Carbon::now();
        Carbon::setLocale('fr');
        // return $value->diffForHumans($now, true);
        return $now->diffInDays($value, false);
    }

    public function getDateLivraisonDelaiAttribute($value)
    {
        $value = $this->date_livraison;
        $now = Carbon::now();
        Carbon::setLocale('fr');
        // return $value->diffForHumans($now, true);
        return $now->diffInDays($value, false);
    }

    public function getLivraisonDelaiExpliciteAttribute($value)
    {
        $value = $this->date_livraison_delai;
        return $value;
    }



    /**
     * Non implémentée.
     * Prévoit la possibilté de fixer des conditions avant qu'une livraison créée puisse être ouverte,
     * (par exemple qu'un nombre minimum de commandes soit atteint).
     *
     * @var array
     */
    public function checkIfOkForOuverture()
    {
        if (1 == 1) {
            return true;
        }
    }

    public function getStatutAttribute($value)
    {
        if ($value == '') {
            $newValue = "L_CREATED";
        }

        if ($this->checkIfOkForOuverture()) {
            $newValue = "L_OUVERTE";
        }

        if ($this->date_cloture->diffInDays(Carbon::now(), false) > 0) {
            $newValue = "L_CLOTURED";
        }

        if ($this->date_livraison->diffInDays(Carbon::now(), false) > 0) {
            $newValue = 'L_ARCHIVABLE';
        }

        if ($value == 'L_ARCHIVED') {
            $newValue = "L_ARCHIVED";
        }

        return $newValue;
    }

    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = $value;

    }

}
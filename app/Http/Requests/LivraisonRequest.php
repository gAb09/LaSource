<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Carbon\Carbon;
use App\Models\Parameter;

class LivraisonRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    public function __construct(Parameter $parameter){
        $this->marge_paiement_livraison = $parameter->where('param', 'marge_paiement_livraison')->first()->valeur;
        $this->marge_cloture_paiement = $parameter->where('param', 'marge_cloture_paiement')->first()->valeur;
        $this->marge_cloture_now = $parameter->where('param', 'marge_cloture_now')->first()->valeur;
    }

    /**
     * Livraison : requis et type date.
     * 
     * Limite paiement : requis, type date, avant date_livraison, 
     * distant d'au moins x jours de date_livraison (avant $date_paiement_max).
     * x est paramétrable par le gestionnaire  = marge_paiement_livraison, $date_paiement_max en est déduite.
     *
     * Cloture : requis, type date, avant date_paiement, après now,
     * distant d'au moins y jours de date_paiement, (avant $date_cloture_max),
     * y est paramétrable par le gestionnaire  = marge_cloture_paiement, $date_cloture_max en est déduite.
     * distant d'au moins z jours de now, (après $date_cloture_min).
     * z est paramétrable par le gestionnaire  = marge_cloture_now, $date_cloture_min en est déduite.
     *
     * @return array
     */
    public function rules()
    {
        // Livraison

        // Limite paiement
        $date_paiement_max = Carbon::createFromFormat('Y-m-d', explode(" ", $this->date_livraison)[0])->subDay($this->marge_paiement_livraison-1);
        // var_dump("now : ".Carbon::now());//CTRL
        // var_dump("date_livraison : ".$this->date_livraison);//CTRL
        // var_dump("date_paiement_max : ".$date_paiement_max);//CTRL

        // Cloture
        $date_cloture_max = Carbon::createFromFormat('Y-m-d', explode(" ", $this->date_paiement)[0])->subDay($this->marge_cloture_paiement-1);
        $date_cloture_min = Carbon::now()->addDay($this->marge_cloture_now-1);
        // var_dump("date_cloture_max : ".$date_cloture_max);//CTRL
        // var_dump("date_cloture_min : ");//CTRL
        // return dd($date_cloture_min);//CTRL



        return [
        'date_livraison' => "required|date",
        'date_paiement' => "required|date|before:$date_paiement_max",
        'date_cloture' => "required|date|before:$date_cloture_max|after:$date_cloture_min",
        ];
    }

    public function messages()
    {
        return [
        'date_paiement.before' => "Date de paiement.<br />Cette date doit PRÉCÉDER<br />la date de livraison<br />d'au moins $this->marge_paiement_livraison jours.",
        'date_cloture.before' => "Date de clôture.<br />Cette date doit PRÉCÉDER<br />la date de PAIEMENT d'au moins $this->marge_cloture_paiement jours.",
        'date_cloture.after' => "Date de clôture.<br />Cette date doit être éloignée d’AUJOURD’HUI<br />d’au moins $this->marge_cloture_now jours.",
        ];
    }
}


<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Carbon\Carbon;

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

    private $margeCloture = 5;
    private $margePaiement = 10;
    private $margeLivraison = 15;



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $buteeCloture = "$this->margeCloture day";
        $buteePaiement = "$this->margePaiement day";
        $buteeLivraison = "$this->margeLivraison day";

        return [
        'date_cloture' => "required|date|after:$buteeCloture|before:date_paiement",
        'date_paiement' => "required|date|after:$buteePaiement|before:date_livraison",
        'date_livraison' => "required|date|after:$buteeLivraison",
        ];
    }

    public function messages()
    {
        return [
        'date_cloture.after' => "Date de clôture.<br />La date choisie est dans moins de $this->margeCloture jours.",
        'date_paiement.after' => "Date de paiement.<br />La date choisie est dans moins de $this->margePaiement jours.",
        'date_livraison.after' => "Date de livraison.<br />La date choisie est dans moins de $this->margeLivraison jours.",
        'date_cloture.before' => 'Date de clôture.<br />Doit être antérieure à celle de paiement.',
        'date_paiement.before' => 'Date de paiement.<br />Doit être antérieure à celle de livraison.',
        ];
    }
}


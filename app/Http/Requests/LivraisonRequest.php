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
        'date_cloture.after' => "La date de clôture est dans moins de $this->margeCloture jours.",
        'date_cloture.before' => 'La date de cloture doit être plus proche que celle de paiement.',
        'date_paiement.before' => 'La date de paiement doit être plus proche que celle de livraison.',
        'date_paiement.after' => "La date de paiement est dans moins de $this->margePaiement jours.",
        'date_livraison.after' => "La date de livraison est dans moins de $this->margeLivraison jours.",
        ];
    }
}


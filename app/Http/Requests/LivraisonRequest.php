<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

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



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'date_livraison' => 'required|date|after:now',
        'date_paiement' => 'required|date|before:date_livraison',
        'date_cloture' => 'required|date|before:date_paiement',
        ];
    }

    public function messages()
    {
        return [
        'date_livraison.after' => 'La date de livraison doit être postérieure à aujourd’hui.',
        'date_paiement.before' => 'La date de paiement doit être antérieure à celle de livraison',
        'date_cloture.before' => 'La date de cloture doit être antérieure à celle de paiement',
        ];
    }
}


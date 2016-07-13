<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PanierForLivraisonRequest extends Request
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
        'producteur.*' => 'required|not_in:0',
        'prix_livraison.*' => 'required|not_in:0',
        ];

    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
        'producteur.*.required' => 'Renseignez un producteur SVP',
        'producteur.*.not_in' => 'Renseignez un producteur SVP',
        'prix_livraison.*.required'  => "Prix manquant ou égal à zéro",
        'prix_livraison.*.not_in'  => "Prix manquant ou égal à zéro",
        ];
    }

}

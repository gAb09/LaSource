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
        'date_livraison' => 'required|date_format:Y-m-d',
        'date_cloture' => 'required|date_format:Y-m-d',
        'date_paiement' => 'required|date_format:Y-m-d',
        ];
    }
}


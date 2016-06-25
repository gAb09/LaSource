<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PanierRequest extends Request
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
        // 'nom' => 'required',
        // 'nom_court' => 'required|alpha_dash',
        // 'famille' => 'required|alpha_dash',
        // 'type' => 'required_with:cp,ville',
        // 'idee' => '',
        // 'prix_commun' => 'required|max:20',
        ];
    }
}


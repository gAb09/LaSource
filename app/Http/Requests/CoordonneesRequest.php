<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CoordonneesRequest extends Request
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
        'prenom' => 'required|alpha_dash',
        'nom' => 'required|alpha_dash',
        'ad1' => 'required_with:ad2,cp,ville',
        'cp' => 'digits:5|required_with:ad1,ad2,ville',
        'ville' => 'required_with:ad1,ad2,cp',
        'tel' => 'required|numeric|digits:10',
        'mobile' => 'numeric|digits:10',
        'email' => 'email|required',
        ];
    }
}


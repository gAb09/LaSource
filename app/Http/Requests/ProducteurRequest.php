<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProducteurRequest extends Request
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
        'exploitation' => 'required',
        'prenom' => 'required|alpha_dash',
        'nom' => 'required',
        'ad1' => 'required_with:cp,ville',
        // 'ad2' => 'required_with:ad1,cp,ville',
        'cp' => 'digits:5|required_with:ad1,ad2,ville',
        'ville' => 'required_with:ad1,ad2,cp',
        'tel' => 'required|numeric|digits:10',
        'mobile' => 'numeric|digits:10',
        'email' => 'email|required',
        'nompourpaniers' => 'required|max:30',
        ];
    }
}


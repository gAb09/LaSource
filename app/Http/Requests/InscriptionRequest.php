<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InscriptionRequest extends Request
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
        'prenom' => 'required|alpha',
        'nom' => 'required|alpha',
        'ad1' => 'required_with:cp,ville',
        // 'ad2' => 'required_with:ad1,cp,ville',
        'cp' => 'digits:5|required_with:ad1,ad2,ville',
        'ville' => 'required_with:ad1,ad2,cp',
        'telephone' => 'digits:10',
        'mobile' => 'digits:10',

        'pseudo' => 'required|max:255|unique:users',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|confirmed',
        ];
    }
}


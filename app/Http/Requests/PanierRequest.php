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
        'nom' => 'required',
        'nom_court' => 'required|alpha_dash',
        'type' => 'required|alpha_dash',
        // 'idee' => '',
        'prix_commun' => 'required|not_in:0|numeric',
        'rang' => 'unique:paniers,rang,'.$this->input('id').'id',
        ];
    }

    public function messages()
    {
        return [
        'rang.unique' => 'Ce rang est déjà pris',
        ];
    }
}


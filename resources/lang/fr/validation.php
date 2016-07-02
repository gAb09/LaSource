<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Le champ :attribute n’est pas accepté.',
    'active_url'           => ':attribute nest pas une URL valide.',
    'after'                => 'Le champ :attribute doit être une date postérieure à : :date.',
    'alpha'                => 'Le champ :attribute ne doit contenir que des lettres.',
    'alpha_dash'           => 'Le champ :attribute ne doit contenir que des lettres, chiffres, et tirets.',
    'alpha_num'            => 'Le champ :attribute ne doit contenir que des lettres et des chiffres.',
    'array'                => 'Le champ :attribute doit être un tableau.',
    'before'               => 'Le champ :attribute doit être une date antérieure à : :date.',
    'between'              => [
        'numeric' => 'Le champ :attribute doit être compris entre :min et :max.',
        'file'    => 'Le champ :attribute doit être compris entre :min et :max kilobytes.',
        'string'  => 'Le champ :attribute doit être compris entre :min et :max characters.',
        'array'   => 'Le champ :attribute doit être compris entre :min et :max items.',
    ],
    'boolean'              => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed'            => 'La confirmation de “:attribute” n’est pas valide.',
    'date'                 => 'Le champ :attribute doit être une date valide.',
    'date_format'          => 'Le champ :attribute doit être saisi au format : format :format.',
    'different'            => 'Les champs :attribute et :other doivent être différents.',
    'digits'               => 'Le champ :attribute doit comporter :digits chiffres.',
    'digits_between'       => 'Le champ :attribute doit comporter entre :min et :max digits.',
    'distinct'             => 'Le champ :attribute contient une valeur redondante.',
    'email'                => 'Le champ :attribute doit être une adresse mail valide.',
    'exists'               => 'La sélection pour :attribute est invalide.',
    'filled'               => 'Le champ :attribute est requis.',
    'image'                => 'Le champ :attribute doit être une image.',
    'in'                   => 'Le champ :attribute n’accepte que ces valeurs : :values.',
    'in_array'             => 'Le champ :attribute doit être une valeur contenue dans :other.',
    'integer'              => 'Le champ :attribute doit être un entier.',
    'ip'                   => 'Le champ :attribute doit être a valid IP address.',
    'json'                 => 'Le champ :attribute doit être a valid JSON string.',
    'max'                  => [
        'numeric' => 'Le champ :attribute ne peut pas être supérieur à :max.',
        'file'    => 'Le champ :attribute ne peut faire plus de :max kilobytes.',
        'string'  => 'Le champ :attribute ne peut faire plus de :max caractères.',
        'array'   => 'Le champ :attribute ne peut contenir plus de :max items.',
    ],
    'mimes'                => 'Le champ :attribute doit être a file of type: :values.',
    'min'                  => [
        'numeric' => 'Le champ :attribute doit comporter au moins :min caractères.',
        'file'    => 'Le champ :attribute doit comporter au moins :min kilobytes.',
        'string'  => 'Le champ :attribute doit comporter au moins :min caractères.',
        'array'   => 'Le champ :attribute doit comporter au moins :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'Le champ :attribute doit être un nombre.',
    'present'              => 'Le champ :attribute est requis.',
    'regex'                => 'Le champ :attribute présente un format invalide.',
    'required'             => 'Le champ “:attribute” est requis.',
    'required_if'          => 'Le champ :attribute est requis si :other vaut :value.',
    'required_unless'      => 'Le champ :attribute est requis tant que :other contient :values.',
    'required_with'        => 'Le champ :attribute est requis si l’un des champs :values est renseigné.',
    'required_with_all'    => 'Le champ :attribute est requis lorsque les champs :values sont renseignés.',
    'required_without'     => 'Le champ :attribute est requis si l’un des champs :values n’est pas renseigné.',
    'required_without_all' => 'Le champ :attribute est requis lorsqu’aucun des champs :values n’est renseigné.',
    'same'                 => 'Les champs :attribute et :other doivent correspondre.',
    'size'                 => [
        'numeric' => 'Le champ :attribute doit être :size.',
        'file'    => 'Le champ :attribute doit faire :size kilobytes.',
        'string'  => 'Le champ :attribute doit contenir :size caractères.',
        'array'   => 'Le champ :attribute doit contenir :size items.',
    ],
    'string'               => 'Le champ :attribute doit être une chaîne de caractères.',
    'timezone'             => 'Le champ :attribute doit être une timezone valide.',
    'unique'               => 'Le champ :attribute est déjà pris.',
    'url'                  => 'Le format du champ :attribute est invalide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
    'pseudo' => 'Pseudo',
    'password' => 'Mot de passe',
    'prenom' => 'Prénom',
    'nom' => 'Nom',
    'ad1' => 'Adresse',
    'ad2' => 'Adresse suite',
    'cp' => 'Code postal',
    'ville' => 'Ville',
    'tel' => 'Téléphone',
    'mobile' => 'Mobile',
    'email' => 'Courriel',
    'nompourpaniers' => 'Nom pour Paniers',
    ],

];

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages La Source
    |--------------------------------------------------------------------------
    |
    | ?????????????????????.
    |
    */

        'accueil'     => 'Les paniers de La Source, mode d’emploi',
        'lesproducteurs'     => 'Nos producteurs',
        'lasource'     => 'Présentation de l’Association La Source',
        'lesrelais'     => 'Nos points relais',
        'lespaniers'     => 'Les paniers',
        'leslivraisons'     => 'Les prochaines livraisons',

        'relais' => 
            [
                'index' => 'Les relais',
                'create'  => 'Création d’un relais',
                'edit'  => 'Édition du relais “:nom”',
            ],

        'producteur' => 
            [
                'index' => 'Les producteurs',
                'create'  => 'Création d’un producteur',
                'edit'  => 'Édition du producteur “:exploitation”',
            ],

        'panier' => 
            [
                'index' => 'Les paniers',
                'create'  => 'Création d’un panier',
                'edit'  => 'Édition du panier “:nom_court',
                'choixproducteurs'  => 'Désigner un (plusieurs) producteur(s) fournissant le panier : :panier_nomcourt',
            ],

        'livraison' => 
            [
                'index' => 'Les livraisons',
                'create'  => 'Création d’une livraison',
                'edit'  => 'Édition de la livraison du&nbsp:date_titrepage',
                'listPaniers'  => 'Choisir un (plusieurs) panier(s) pour la livraison : :date',
                'editpanier'  => 'Modification du panier :panier',
            ],
        

        'modepaiement' => 
            [
                'index' => 'Les modes de paiement',
                'create'  => 'Création d’un mode de paiement',
                'edit'  => 'Édition du mode de paiement “:nom”',
            ],

        'client' => 
            [
                'index' => 'Les clients',
                'edit'  => 'Modification de mes coordonnées',
            ],
    ];

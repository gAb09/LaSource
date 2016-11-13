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
                'trashed'  => 'Réhabilitation des relais supprimés',
            ],

        'producteur' => 
            [
                'index' => 'Les producteurs',
                'create'  => 'Création d’un producteur',
                'edit'  => 'Édition du producteur “:exploitation”',
                'trashed'  => 'Réhabilitation des producteurs supprimés',
            ],

        'panier' => 
            [
                'index' => 'Les paniers',
                'create'  => 'Création d’un panier',
                'edit'  => 'Édition du panier <span style="font-style:italic">“:type / :nom_court”</span>',
                'choixproducteurs'  => 'Désigner un (plusieurs) producteur(s) fournissant le panier : :panier_nomcourt',
                'trashed'  => 'Réhabilitation des paniers supprimés',
            ],

        'livraison' => 
            [
                'index' => 'Les livraisons',
                'create'  => 'Création d’une livraison',
                'edit'  => 'Édition de la livraison du&nbsp:date_titrepage',
                'listPaniers'  => 'Choisir un (plusieurs) panier(s) pour la livraison : :date',
                'editpanier'  => 'Modification du panier :panier',
                'enCours'  => 'Les livraisons en cours',
                'handleIndisponibilities'  => ':action de l’indisponibilité de “:indisponisable” peut avoir des répercussions sur certaines livraisons ouvertes :',
            ],
        

        'modepaiement' => 
            [
                'index' => 'Les modes de paiement',
                'create'  => 'Création d’un mode de paiement',
                'edit'  => 'Édition du mode de paiement “:nom”',
                'trashed'  => 'Réhabilitation des modes de paiement supprimés',
            ],

        'client' => 
            [
                'index' => 'Les clients',
                'edit'  => 'Modification de mes coordonnées',
                'trashed'  => 'Réhabilitation des clients supprimés',
            ],

        'indisponibilite' => 
            [
                'create' => 'Ajout d’une période d’indisponibilité :entity “:nom”',
                'edit' => 'Modification d’une période d’indisponibilité associée à <br />“:nom”',
            ],

        'dashboard' => 
            [
                'main' => 'Tableau de bord',
            ],

    ];

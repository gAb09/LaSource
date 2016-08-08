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

    'client' => [
        'updateOk'     => 'Vos coordonnées ont bien été modifiées.',
        'updatefailed' => 'Problème. Vos coordonnées n\ont pas été mises à jour…',
        'storeOk'           => 'Le client a bien été créé.',
        'storefailed'       => 'Problème. Le client n’a pas pu être créé…',
        'deleteOk'           => 'Le client a bien été supprimé.',
        'deletefailed'       => 'Problème. Le client n’a pas pu être supprimé…',
        'confirmDelete'    => 'Êtes-vous sur de vouloir supprimer le client “:model” ?\nTous les liens éventuels avec …… seront supprimés.',
    ],

    'producteur' => [
        'updateOk'      => 'Le producteur a bien été modifié.',
        'updatefailed'  => 'Problème. Le producteur n’a pas été mis à jour…',
        'storeOk'       => 'Le producteur a bien été créé.',
        'storefailed'   => 'Problème. Le producteur n’a pas pu être créé…',
        'deleteOk'      => 'Le producteur a bien été supprimé.',
        'deletefailed'  => 'Problème. Le producteur n’a pas pu être supprimé…',
        'setRangsOk'        => 'L’ordre des producteurs a bien été modifié.',
        'setRangsFailed'    => 'L’ordre des producteurs n’a pas pu été modifié.',
        'liedToLivraison'    => 'Ce producteur est fournisseur pour la livraison du :date',
        'confirmDelete'    => 'Êtes-vous sur de vouloir supprimer le producteur “:model” ?\nTous les liens éventuels avec des paniers seront supprimés.',
    ],

    'relais' => [
        'updateOk'      => 'Le relais a bien été modifié.',
        'updatefailed'  => 'Problème. Le relais n’a pas été mis à jour…',
        'storeOk'       => 'Le relais a bien été créé.',
        'storefailed'   => 'Problème. Le relais n’a pas pu être créé…',
        'deleteOk'      => 'Le relais a bien été supprimé.',
        'deletefailed'  => 'Problème. Le relais n’a pas pu être supprimé…',
        'setRangsOk'        => 'L’ordre des relais a bien été modifié.',
        'setRangsFailed'    => 'L’ordre des relais n’a pas pu été modifié.',
        'liedToLivraison'    => 'Ce relais participe à la livraison du :date',
        'confirmDelete'    => 'Êtes-vous sur de vouloir supprimer le relais “:model” ?\nTous les liens éventuels avec …… seront supprimés.',
    ],

    'panier' => [
        'updateOk'          => 'Le panier a bien été modifié.',
        'updatefailed'      => 'Problème. Le panier n’a pas été mis à jour…',
        'storeOk'           => 'Le panier a bien été créé.',
        'storefailed'       => 'Problème. Le panier n’a pas pu être créé…',
        'deleteOk'          => 'Le panier a bien été supprimé.',
        'deletefailed'      => 'Problème. Le panier n’a pas pu être supprimé…',
        'setRangsOk'        => 'L’ordre des paniers a bien été modifié.',
        'setRangsFailed'    => 'L’ordre des paniers n’a pas pu été modifié.',
        'liedToLivraison'    => 'Ce panier est proposé dans la livraison du :date',
        'confirmDelete'    => 'Êtes-vous sur de vouloir supprimer le panier “:model” ?\nTous les liens éventuels avec des producteurs seront supprimés.',
    ],

    'modepaiement' => [
        'updateOk'      => 'Le mode de paiement a bien été modifié.',
        'updatefailed'  => 'Problème. Le mode de paiement n’a pas été mis à jour…',
        'storeOk'       => 'Le mode de paiement a bien été créé.',
        'storefailed'   => 'Problème. Le mode de paiement n’a pas pu être créé…',
        'deleteOk'      => 'Le mode de paiement a bien été supprimé.',
        'deletefailed'  => 'Problème. Le mode de paiement n’a pas pu être supprimé…',
        'confirmDelete'    => 'Êtes-vous sur de vouloir supprimer le mode de paiement “:model” ?\nTous les liens éventuels avec …… seront supprimés.',
    ],

    'livraison' => [
        'updateOk'      => 'Les dates ont bien été modifiées.',
        'updatefailed'  => 'Problème. La livraison n’a pas pu être mise à jour…',
        'storeOk'       => 'La livraison a bien été créée.',
        'storefailed'   => 'Problème. La livraison n’a pas pu être créée…',
        'deleteOk'      => 'La livraison a bien été supprimée.',
        'deletefailed'  => 'Problème. La livraison n’a pas pu être supprimée…',
        'syncOk'        => 'Les paniers ont bien été actualisés :result.',
        'syncfailed'    => 'Problème. La livraison n’a pas pu être actualisée',
    ],

    'user' => [
        'updateOk'     => 'Vos identifiants ont bien été modifiés.',
        'updatefailed' => 'Problème. Vos identifiants n\ont pas été mis à jour…',
    ],
    ];

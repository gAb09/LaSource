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
    'updateOk'              => 'Vos coordonnées ont bien été modifiées.',
    'updatefailed'          => 'Problème. Vos coordonnées n’ont pas été mises à jour…',
    'storeOk'               => 'Le client a bien été créé.',
    'storefailed'           => 'Problème. Le client n’a pas pu être créé…',
    'deleteOk'              => 'Le client a bien été supprimé.',
    'deletefailed'          => 'Problème. Le client n’a pas pu être supprimé…',
    'confirmDelete'         => 'Êtes-vous sur de vouloir supprimer le client “:model” ?\nTous les liens éventuels avec …… seront supprimés.',
    'setPrefRelaisOK'       => 'Le changement de relais par défaut a bien été pris en compte.<br />ATTENTION : ce changement changement vient d’être répercuté sur toutes les commandes actuellement affichées !',
    'setPrefRelaisFailed'   => 'Problème : le relais par défaut n’a pas pu être enregistré',
    'setPrefPaiementOK'        => 'Le changement de mode de paiement par défaut a bien été pris en compte.<br />ATTENTION : ce changement vient d’être répercuté sur toutes les commandes actuellement affichées !',
    'setPrefPaiementFailed'    => 'Problème : le mode de paiement par défaut n’a pas pu être enregistré',
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
    'restoreOk'      => 'Le producteur a bien été restauré.',
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
    'reattachOk'    => 'Le relais vient d’être lié à nouveau.',
    'reattachFailed'    => 'Problème. Le relais n’a pas pu être lié…',
    'restoreOk'      => 'Le relais a bien été restauré.',
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
    'restoreOk'      => 'Le panier a bien été restauré.',
    ],

    'modepaiement' => [
    'updateOk'      => 'Le mode de paiement a bien été modifié.',
    'updatefailed'  => 'Problème. Le mode de paiement n’a pas été mis à jour…',
    'storeOk'       => 'Le mode de paiement a bien été créé.',
    'storefailed'   => 'Problème. Le mode de paiement n’a pas pu être créé…',
    'deleteOk'      => 'Le mode de paiement a bien été supprimé.',
    'deletefailed'  => 'Problème. Le mode de paiement n’a pas pu être supprimé…',
    'setRangsOk'        => 'L’ordre des modes de paiement a bien été modifié.',
    'setRangsFailed'    => 'L’ordre des modes de paiement n’a pas pu été modifié.',
    'liedToLivraison'    => 'Ce mode de paiement est proposé dans la livraison du :date',
    'confirmDelete'    => 'Êtes-vous sur de vouloir supprimer le mode de paiement “:model” ?\nTous les liens éventuels avec …… seront supprimés.',
    'restoreOk'      => 'Le mode de paiement a bien été restauré.',
    ],

    'livraison' => [
    'updateOk'      => 'Les dates ont bien été modifiées.',
    'updatefailed'  => 'Problème. La livraison n’a pas pu être mise à jour…',
    'storeOk'       => 'La livraison a bien été créée.',
    'storefailed'   => 'Problème. La livraison n’a pas pu être créée…',
    'deleteOk'      => 'La livraison a bien été supprimée.',
    'deletefailed'  => 'Problème. La livraison n’a pas pu être supprimée…',
    'syncPaniersOk'        => 'Les paniers ont bien été actualisés :result.',
    'syncPaniersfailed'    => 'Problème. Les paniers de cette livraison n’ont pus être actualisés',
    'syncRelaissOk'        => 'Les relais ont bien été actualisés :result.',
    'syncRelaissfailed'    => 'Problème. Les relais de cette livraison n’ont pus être actualisés',
    'archivageOk'        => 'La livraison a bien été archivée.',
    'archivagefailed'    => 'Problème. La livraison n’a pas pu être archivée…',
    'handleConcernedOk'        => '<br />Les modifications éventuelles demandées ont été apportées aux livraisons.',
    'handleConcernedfailed'    => 'Un problème est survenu aucune modifications n’ont été apportées, ni à l’indisponibilité, ni aux livraisons.<br />Veuillez réessayer et contacter le Ouaibmaistre si l’erreur persiste',
    'ouvertes'              => '{0} Il n’y a aucune livraison ouverte à la commande | {1}Il y a une livraison ouverte à la commande | [2, Inf] Il y a :count livraisons ouvertes à la commande'
    ],

    'commande' => [
    'encours'              => '{0} - Vous n’avez aucune commande en cours. |{1} - Vous avez une commande en cours. | [2, Inf] - Vous avez :count commandes en cours.',
    'storeOk'       => '{1} Votre commande a bien été prise en compte. | [2, Inf] Vos :count commandes ont bien été prises en compte.',
    'storeNul'       => 'Aucune commande n’a été validée (toutes les quantités étaient nulles).',
    'storefailed'       => 'Problème. Votre demande n’a pas pu être prise en compte…',
    ],

    'indisponibilite' => [
    'storeOk'           => 'La période d’indisponibilité a bien été créée.',
    'storefailed'       => 'Problème. La période d’indisponibilité n’a pas pu être créée…',
    'updateOk'          => 'La période d’indisponibilité a bien été modifiée.',
    'updatefailed'      => 'Problème. La période d’indisponibilité n’a pas pu être mise à jour…',
    'deleteOk'          => 'La période d’indisponibilité a bien été supprimée.',
    'deletefailed'      => 'Problème. La période d’indisponibilité n’a pas pu être supprimée…',
    'confirmDelete'     => 'Êtes-vous sur de vouloir supprimer la période d’indisponibilité ?',
    'controleFailed'    => 'Problème. La période d’indisponibilité n’a pas pu être traitée…<br />car les contrôles avant traitement n’ont pas pu être effectués correctement.',
    'actionCancelled'    => 'Annulation bien prise en compte.<br />Aucune modification n’a été apportée ni à l’indisponibilité ni aux livraisons liées',
    ],

    'user' => [
    'updateOk'     => 'Vos identifiants ont bien été modifiés.',
    'updatefailed' => 'Problème. Vos identifiants n\ont pas été mis à jour…',
    ],

    'activation' => [
    'activeOk'     => 'Le :model a bien été activé',
    'activeFailed' => 'Problème. Le :model n’a pas pu être activé',
    'desactiveOk'     => 'Le :model a bien été desactivé',
    'desactiveFailed' => 'Problème. Le :model n’a pas pu être desactivé',
    ],

    'bug' => [
    'transmis'     => '<br />Le Ouaibmaistre vient d’en être informé et va répondre à ce problème dès que possible',
    ],
    ];
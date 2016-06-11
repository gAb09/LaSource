<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Reset Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */

    'failed' => 
    "Désolé le transfert depuis l'ancienne application a échoué. <br />
    Vous devez procéder à une nouvelle inscription.<br />
    Il vous sera possible de passer des nouvelles commandes,<br />
    mais, (temporairement) vous n'aurez pas accès à vos anciennes commandes.<br />
    Notre Ouaibmestre vient d'être prévenu de ce dysfonctionnement et va rapidement faire le nécessaire.",

    'compteintrouvable' => 
    "Cette adresse ne correspond à aucun compte connu. <br />
    Vous pouvez réessayer ou bien ".link_to('register', 'vous inscrire').".",
    
    'success' => 
    "Votre compte vient d'être transféré avec succès !<br />
    Si toutefois vous deviez rencontrer ultérieurement un dysfonctionnement,<br />
    faites-le savoir au Ouaibmaistre en cliquant sur le lien en pied de page.",

];

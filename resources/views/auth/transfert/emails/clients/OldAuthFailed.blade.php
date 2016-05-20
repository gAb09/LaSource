<?php $clientOld = $datas['clientOld'] ?>

Bonjour {{$clientOld->prenom}} {{$clientOld->nom}}.<br />

Il semble que vous ayez un problème avec vos identifiants.<br />
Votre login est : {{ $clientOld->login_client }}<br />
Voici un mot de passe temporaire : {{ $datas['mdp_tempo'] }}<br />
Vous pourrez modifier celui-ci une fois de retour dans votre espace client.<br /><br />

Vous pouvez vous connecter en cliquant sur ce lien :<br />
<a href="{{ $link = url('connexion').'/'.$clientOld->login_client }}"> {{ $link }} </a>




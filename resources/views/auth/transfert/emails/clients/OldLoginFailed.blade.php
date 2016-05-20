<?php $clientOld = $datas['clientOld'] ?>

Bonjour {{$clientOld->prenom}} {{$clientOld->nom}}.<br />

Il semble que vous ayez un problème avec votre pseudo.<br />
Celui-ci est : {{ $clientOld->login_client }}<br />
Votre mot de passe est inchangé.<br /><br />

Vous pouvez réessayer de vous connecter en cliquant sur ce lien :<br />
<a href="{{ $link = url('connexion').'/'.$clientOld->login_client }}"> {{ $link }} </a>




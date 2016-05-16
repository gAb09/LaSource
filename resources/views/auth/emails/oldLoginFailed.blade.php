Bonjour {{$clientOld->prenom}} {{$clientOld->nom}}.<br />

Il semble que vous ayez un problème avec votre pseudo.

Vous pouvez réessayer de vous connecter en cliquant sur ce lien :

<a href="{{ $link = url('connexion').'/'.$clientOld->login_client }}"> {{ $link }} </a>




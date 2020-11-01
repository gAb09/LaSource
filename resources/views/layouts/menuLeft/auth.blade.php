<li class="dropdown">
	<a href="" class="" data-toggle="dropdown" role="button" aria-expanded="false">
		Les livraisons <span class="caret"></span>
	</a>

	<ul class="dropdown-menu" role="menu">
		<li><a href="{{ route('livraison.create') }}">Créer</a></li>
		<li><a href="{{ route('dashboard') }}">En cours</a></li>
		<li><a href="{{action('LivraisonController@index')}}">Liste complète</a></li>
	</ul>
</li>

<li>{{Html::linkAction('PanierController@index', 'Les paniers')}}</li>

<li>{{Html::linkAction('ProducteurController@index', 'Les producteurs')}}</li>

<li>{{Html::linkAction('RelaisController@index', 'Les relais')}}</li>

<li>{{Html::linkAction('ModePaiementController@index', 'Les modes de paiement')}}</li>

<li>{{Html::linkAction('ClientController@index', 'Les clients')}}</li>

<li>{{Html::linkAction('CommandeController@index', 'Les commandes')}}</li>

<li>{{Html::linkAction('UserController@index', 'Les users')}}</li>

<li class="dropdown">
	<a href="" class="" data-toggle="dropdown" role="button" aria-expanded="false">
		Restaurer <span class="caret"></span>
	</a>

	<ul class="dropdown-menu" role="menu">
		<li><a href="{{ route('panier.getdeleted') }}">Panier</a></li>
		<li><a href="{{ route('producteur.getdeleted') }}">Producteur</a></li>
		<li><a href="{{ route('relais.getdeleted') }}">Relais</a></li>
		<li><a href="{{ route('modepaiement.getdeleted') }}">Mode de Paiement</a></li>
		<li><a href="{{ route('client.getdeleted') }}">Client</a></li>
	</ul>
</li>

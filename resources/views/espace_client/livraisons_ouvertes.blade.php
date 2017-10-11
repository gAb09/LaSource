<h3>Livraisons ouvertes à la commande</h3>
@forelse($livraisons as $livraison)

	<h4>Livraison du {{$livraison->date_livraison_enclair}}</h4>
	Cette livraison sera accessible jusqu'au {{$livraison->date_cloture_enclair}},<br />
	avec paiement avant le {{$livraison->date_paiement_enclair}}
	<h5>Les paniers proposés :</h5>
	@forelse($livraison->panier as $panier)
		<p>
		{{ $panier->famille }}{{ $panier->nom_sans_retours }} ({{$panier->prix_base}} euros)<br />
		Producteur : {{$panier->exploitation}}<br />
		Prix : {{$panier->pivot->prix_livraison}} euros
		</p>
	@empty
		<p class="is_error_txt">
		Tiens ! Aucun panier n'est prévu ??
		</p>
	@endforelse
	<a href="{{ route('commande.create') }}" class="btn btn-success">Passer une commande</a><br />
@empty
	À ce jour, pas de livraison programmée
@endforelse



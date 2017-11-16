<h4>Livraison du @date_complete($livraison->date_livraison)</h4>
<h5>
	Commandes ouvertes jusqu'au @date_complete($livraison->date_cloture)<br />
	Paiement possible jusqu'au @date_complete($livraison->date_paiement)
</h5>

<table class="livraison" style="width:100%">
	<thead>
		<tr>
			<th class="identifiant">Id panier</th>
			<th class="surligned panier">Panier</th>
			<th class="producteur">Producteur</th>
			@foreach($livraison->relais as $relais)
			<th class="relais">{{$relais->nom}}</th>
			@endforeach
			<th class="surligned total">Total</th>
			<th class="prix">Prix (euros)</th>
		</tr>
	</thead>

	@foreach($livraison->panier as $panier)
	<tr>
		<td class="identifiant">{{$panier->id}}</td>
		<td class="surligned panier"><small>{{$panier->type}}</small><br/>{{$panier->nom_court}}</td>
		<td class="producteur">{{$panier->exploitation}}</td>
		@foreach($panier->relais as $relais => $value)
		@if($relais == 'total')
		<td class="surligned relais quantite">{{$value}}</td>
		@else
		<td class="relais quantite">{{$value}}</td>
		@endif
		@endforeach
		<td class="prix">@nbreFR($panier->pivot->prix_livraison)</td>
	</tr>
	@endforeach
		<tr>
		<td colspan="{{ $livraison->relais->count()+2 }}"></td>
		<td class="libelle_chiffre_affaire" colspan="2">Total livraison</td>
		<td class="total_livraison surligned">@nbreFR($livraison->chiffre_affaire)</td>
	</tr>

</table>
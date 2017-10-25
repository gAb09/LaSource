<tr class="top_txt" >
	<td class="Panier" >

		@if($ligne->panier_id == 3 or $ligne->panier_id == 6)
			<span class="is_error_txt">Panier obsolète</span><br/>
		</td>
		@else
			{{ str_replace('<br/>', ' ', $ligne->panier->nom )  }}<br/>

			<small><small>
			@if(!isset($ligne->producteur))
				<span class="is_error_txt">Producteur non spécifié</span>
			@else
				{{$ligne->producteur}}
			@endif
			</small></small>

		</td>

		<td>
			<b>{{ $ligne->quantite }}</b>
		</td>

		<td>
			x<br/>
		</td>

		<td>

		@if(!isset($ligne->prix_livraison))
			<span class="is_error_txt">OUPSss</span>
		@else
			{{ $ligne->prix_livraison }}
		@endif
		</td>

		<td>
			=<br/>
		</td>

		<td>
			{{ $ligne->montant_ligne }}
		</td>

		<!--td>
			Relais : {{ $commande->relais->nom }}
		</td>

		<td>
			Paiement par {{ $commande->modepaiement->nom }}
		</td-->

		@endif

</tr>

<tr class="top_txt" >
	<td class="Panier" >
		@if($ligne->panier_id == 3 or $ligne->panier_id == 6)
			<span class="is_error_txt">Panier obsolète</span><br/>
		@else
			{{ str_replace('<br/>', ' ', $ligne->panier )  }}<br/>
		<small><small>
		@if($ligne->producteur == 0)
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
		{{ $ligne->prix_livraison }}
	</td>
	<td>
		=<br/>
	</td>
	<td>
		{{ $ligne->montant_ligne }}
	</td>
			@endif

</tr>

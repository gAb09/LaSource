<tr class="top_txt" >
	<td class="Panier" >
		@if($ligne->panier_id == 3 or $ligne->panier_id == 6)
			<span class="is_error_txt">Panier obsolète</span><br/>
		@else
			{{ str_replace('<br/>', ' ', $ligne->Panier->nom )  }}<br/>
		<small><small>
		@if($ligne->producteur_id == 0)
			<span class="is_error_txt">Producteur non spécifié</span>
		@else
			{{$ligne->Producteur->exploitation}}
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
		{{ $ligne->prix_final }}
	</td>
	<td>
		=<br/>
	</td>
	<td>
		{{ $ligne->montant_ligne }}
	</td>
			@endif

</tr>

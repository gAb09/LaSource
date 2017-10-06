			
<tr class="top_txt" >
	<td class="Panier" >

		@if($ligne->panier_id == 3 or $ligne->panier_id == 6)
			<span class="is_error_txt">Panier obsolète</span><br/>
		@else
			{{ str_replace('<br/>', ' ', $ligne->panier->nom )  }}<br/>

				<small><small>
				@if(!isset($ligne->complement[0]->producteur))
					<span class="is_error_txt">Producteur non spécifié</span>
				@else
					{{$ligne->complement[0]->producteur}}
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

			@if(!isset($ligne->complement[0]->prix_livraison))
				<span class="is_error_txt">OUPS</span>
			@else
				{{ $ligne->complement[0]->prix_livraison }}
			@endif
			</td>

			<td>
				=<br/>
			</td>

			<td>
				{{ $ligne->montant_ligne }}
			</td>
		@endif

</tr>

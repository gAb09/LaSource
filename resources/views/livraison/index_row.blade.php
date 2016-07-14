<div 
class="flexcontainer ligne_livraison ombrable"
id="row_{{ $item->id }}" 
onDblClick="javascript:document.location.href='{{ route('livraison.edit', $item->id) }}' ;"
>

	<!-- id -->
	<div>
		{{ $item->id }}
	</div>

	<!-- date_cloture -->
	<div>
		{!! $item->ClotureEnClair !!}
	</div>

	<!-- date_paiement -->
	<div>
		{!! $item->PaiementEnClair !!}
	</div>

	<!-- date_livraison -->
	<div>
		{!! $item->LivraisonEnClair !!}
	</div>


</div>

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
		{!! $item->date_clotureFR !!}
	</div>

	<!-- date_paiement -->
	<div>
		{!! $item->date_paiementFR !!}
	</div>

	<!-- date_livraison -->
	<div>
		{!! $item->date_livraisonFR !!}
	</div>


</div>

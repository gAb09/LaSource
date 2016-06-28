<div 
class="flexcontainer ligne_livraison"
id="row_{{ $item->id }}" 
onDblClick="javascript:edit({{ $item->id }});"
>

	<!-- id -->
	<div>
		{{ $item->id }}
	</div>

	<!-- date_cloture -->
	<div>
		{!! $item->cloture !!}
	</div>

	<!-- date_paiement -->
	<div>
		{!! $item->paiement !!}
	</div>

	<!-- date_livraison -->
	<div>
		{!! $item->livraison !!}
	</div>


</div>

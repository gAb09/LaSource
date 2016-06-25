<tr 
class="s"
id="row_{{ $item->id }}" 
onDblClick="javascript:edit(this, {{ $item->id }});"
>

	<!-- id -->
	<td>
		{{ $item->id }}
	</td>

	<!-- date_livraison -->
	<td>
		{!! $item->livraison !!}
	</td>

	<!-- date_cloture -->
	<td>
		{!! $item->cloture !!}
	</td>

	<!-- date_paiement -->
	<td>
		{!! $item->paiement !!}
	</td>


</tr>

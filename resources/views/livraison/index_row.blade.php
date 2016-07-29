<tr 
class="index_livraison ombrable"
id="row_{{ $item->id }}" 
onDblClick="javascript:document.location.href='{{ route('livraison.edit', $item->id) }}' ;"
>

	<!-- id -->
	<td>
		{{ $item->id }}
	</td>

	<!-- date_cloture -->
	<td>
		{{ $item->date_cloture_enclair }}
	</td>

	<!-- date_paiement -->
	<td>
		{{ $item->date_paiement_enclair }}
	</td>

	<!-- date_livraison -->
	<td>
		{{ $item->date_livraison_enclair }}
	</td>


</tr>

<tr 
class="index_livraison ombrable"
id="row_{{ $model->id }}" 
onDblClick="javascript:document.location.href='{{ route('livraison.edit', $model->id) }}' ;"
>

	<!-- id -->
	<td>
		{{ $model->id }}
	</td>

	<!-- date_cloture -->
	<td>
		{{ $model->date_cloture_enclair }}
	</td>

	<!-- date_paiement -->
	<td>
		{{ $model->date_paiement_enclair }}
	</td>

	<!-- date_livraison -->
	<td>
		{{ $model->date_livraison_enclair }}
	</td>


</tr>

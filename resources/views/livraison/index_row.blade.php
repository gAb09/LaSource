<tr 
class="ombrable"
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

	<!-- state -->
	<td class="{{$model->state}}">
		@if($model->state == 'L_ARCHIVABLE')
			<button class="btn btn-info btn-xs">Archiver
			</button>
		@else
			{{ trans('constante.'.$model->state) }}
		@endif
	</td>


</tr>

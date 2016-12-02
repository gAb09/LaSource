<tr 
class="ombrable"
id="row_{{ $model->id }}" 
onDblClick="javascript:document.location.href='{{ route('livraison.edit', $model->id) }}' ;"
>

	<!-- id -->
	<td>
		{{ $model->id }}
		<span class="datecreation">{{ $model->date_creation_courte }}</span>
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
		<form method="POST" name="livraison_archive" action="{{ URL::route('livraison.archive', $model->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="PATCH">
			<button class="btn btn-info btn-xs">
				                                    <i class="fa fa-btn fa-archive"></i>Archiver
			</button>
		</form>
		@else
			{{ trans('constante.'.$model->state) }}
		@endif
	</td>


</tr>

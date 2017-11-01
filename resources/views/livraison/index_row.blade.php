<tr
class="ombrable"
id="row_{{ $model->id }}"
onDblClick="javascript:document.location.href='{{ route('livraison.edit', $model->id) }}' ;"
>

	<!-- id -->
	<td style="width:10%">
		{{ $model->id }}
		<br /><span class="datecreation">{{ $model->date_creation_courte }}</span>
	</td>

	<!-- date_livraison -->
	<td style="font-weight:900">
		@date_complete($model->date_livraison)
	</td>

	<!-- date_paiement -->
	<td>
		@date_complete($model->date_paiement)
	</td>

	<!-- date_cloture -->
	<td>
		@date_complete($model->date_cloture)
	</td>

	<!-- state -->
	<td class="{{$model->state}}">
		@if($model->statut == 'L_ARCHIVABLE')
		<form method="POST" name="livraison_archive" action="{{ URL::route('livraison.archive', $model->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="PATCH">
			<button class="btn btn-info btn-xs">
				                                    <i class="fa fa-btn fa-archive"></i>Archiver
			</button>
		</form>
		@else
			{{ trans('constante.'.$model->statut) }}
		@endif
	</td>


</tr>

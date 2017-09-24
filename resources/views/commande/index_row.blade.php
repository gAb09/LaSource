<tr 
class="ombrable"
id="row_{{ $model->id }}" 
>

	<!-- numero + date création -->
	<td>
		{{ $model->numero }}<br/>
		<span class="datecreation">{{ $model->date_creation_courte }}</span>
	</td>


	<!-- client -->
	<td>
		@if($model->client)
		{{ $model->client->nom_complet }}
		@else
		<span class="is_error_txt">Client inconnu !</span>
		@endif             
	</td>


	<!-- Paniers commandés -->
	<td>
		<table>
			@if($model->has('lignes'))
			@foreach($model->lignes as $ligne)
				@include("commande.ligne")
			@endforeach
			<tr>
				<td>TOTAL :
				</td>
				<td>
				</td>
				<td style='margin:5px;font-size:smaller' >
				</td>
				<td>
				</td>
				<td>
				</td>
				<td>
					{{ $model->montant_total }}
				</td>
			</tr>
			@else
			<tr class="is_error_txt">Commande factice (sans lignes)</tr>
			@endif
		</table>
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
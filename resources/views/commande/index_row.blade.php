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
<td class="lignes_commande">
	<table class="lignes_commande">
		<tbody>
			@if($model->has('lignes'))
			@foreach($model->lignes as $ligne)
			@include("commande.ligne")
			@endforeach
			<tr class="total">
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
		</tbody>
	</table>
</td>


<!-- livraison -->
<td>
	@if($model->livraison_id != 0)
		{{ $model->livraison->date_livraison_enclair }}
	@else
		<span class="is_error_txt">
			Livraison non identifiée
		</span>
	@endif
</td>

<!-- state -->
<td class="{{$model->state}}">
	@if($model->state == 'C_ARCHIVABLE')
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

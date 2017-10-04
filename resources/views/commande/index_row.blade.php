<tr 
class="ombrable"
id="row_{{ $model->idcommande }}" 
>

<!-- numero + date création -->
<td>
	{{ $model->numero }}<br/>
	<span class="datecreation">{{ $model->datecreation }}</span>
</td>


<!-- client -->
<td>
	@if($model->client != 0)
	{{ $model->client }}
	@else
	<span class="is_error_txt">Client inconnu !</span>
	@endif             
</td>


<!-- Paniers commandés -->
<td class="lignes_commande">
	<table class="lignes_commande">
		<tbody>
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
 		</tbody>
	</table>
</td>


<!-- livraison -->
<td>
	@if($model->date_livraison !== 0)
		{{ $model->date_livraison }}
	@else
		<span class="is_error_txt">
			Livraison non identifiée
		</span>
	@endif
</td>


<!-- mode paiement -->
<td>
		{{ $model->modepaiement }}
</td>


<!-- relais -->
<td>
		{{ $model->relais }}
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

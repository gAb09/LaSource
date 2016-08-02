@forelse($models as $model)
<div style="position:relative" class="fiche {{$model->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/producteur/{{ $model->id }}/edit';">

	@if(!isset($trashed))
	@include('layouts.button.supp', ['model' => 'producteur', 'model_id' => $model->id, 'text_confirm' => trans('message.producteur.confirmDelete', ['model' => "$model->nompourproducteurs"]) ])
	@endif
	@include('layouts.button.edite', ['model' => 'producteur', 'model_id' => $model->id])

	<p class="lighten66">{{ $model->exploitation }}<br />
		{{ $model->prenom }} {{ $model->nom }}
	</p>
	<p><strong>{{ $model->nompourproducteurs }}</strong></p>
	<p class="lighten50">
		{{ $model->tel }}<br />
		{{ $model->mobile }}<br />
		{{ $model->ad1 }}<br />
		@if($model->ad2)
		{{ $model->ad2 }}
		@endif
		{{ $model->cp }} {{ $model->ville }}<br />
		{{ $model->email }}
	</p>

	<p class="remarques">
		{!! $model->remarques !!}
	</p>

	<p class="hidden id">{{ $model->id }}</p> {{-- surtout pas de CR dans cette ligne --}}

	<p class="hidden rang">
		rang : {{ $model->rang }}
	</p>
	<br /> {{-- pour chasser d'une ligne à cause des boutons --}}

</div>
@empty 
<h3>Aucun producteur supprimé
@include('producteur.button.index', ['etiquette' => 'Liste des producteurs'])
</h3>
@endforelse
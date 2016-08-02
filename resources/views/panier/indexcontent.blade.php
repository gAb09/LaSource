@forelse($models as $model)
<div style="position:relative" class="fiche {{$model->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/panier/{{ $model->id }}/edit';">

	@if(!isset($trashed))
	@include('layouts.button.supp', ['model' => 'panier', 'model_id' => $model->id, 'text_confirm' => trans('message.panier.confirmDelete', ['model' => "$model->type - $model->nom_court"]) ])
	@endif
	@include('layouts.button.edite', ['model' => 'panier', 'model_id' => $model->id])

	<p class="lighten66">{{ $model->type }}<br />
		<strong>{!! $model->nom_court !!}</strong>
	</p>

	<p class="" style="font-style:italic">
		{!! $model->idee !!}
	</p>

	<p class="lighten50">
		{!! $model->nom !!}<br />
	</p>

	<p>
		<strong>{{ $model->prix_commun }}</strong>
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


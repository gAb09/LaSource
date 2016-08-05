<div id="paniers_index" class="offset3 span11 flexcontainer">
	@forelse($models as $model)
	<div class="fiche stickycontainer {{$model->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/panier/{{ $model->id }}/edit';">

		<div class="allowstickyfooter">

			<p class="lighten66 inset_shadow">{{ $model->type }}<br />
				<strong>{!! $model->nom_court !!}</strong>
			</p>

			<p class="" style="font-style:italic">
				{!! $model->idee !!}
			</p>

			<p class="lighten50 inset_shadow">
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
		</div>

		<div class="footer flexcontainer">
			@if(!isset($trashed))
			@include('layouts.button.supp', ['model' => 'panier', 'model_id' => $model->id, 'text_confirm' => trans('message.panier.confirmDelete', ['model' => "$model->type - $model->nom_court"]) ])
			@endif
			@include('layouts.button.edite', ['model' => 'panier', 'model_id' => $model->id])
		</div>

	</div>
	@empty 
	<h3>Aucun panier supprimé
		@include('panier.button.index', ['etiquette' => 'Liste des paniers'])
	</h3>
	@endforelse
</div>

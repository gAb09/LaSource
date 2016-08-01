@forelse($items as $item)
<div style="position:relative" class="portrait {{$item->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/panier/{{ $item->id }}/edit';">

	@include('layouts.button.supp', ['model' => 'panier', 'model_id' => $item->id, 'text_confirm' => trans('message.panier.confirmDelete', ['panier' => "$item->type - $item->nom_court"]) ])
	@include('layouts.button.edite', ['model' => 'panier', 'model_id' => $item->id])

	<p class="lighten66">{{ $item->type }}<br />
		<strong>{!! $item->nom_court !!}</strong>
	</p>

	<p class="" style="font-style:italic">
		{!! $item->idee !!}
	</p>

	<p class="lighten50">
		{!! $item->nom !!}<br />
	</p>

	<p>
		<strong>{{ $item->prix_commun }}</strong>
	</p>

	<p><small>
		{!! $item->remarques !!}</small>
	</p>

	<p class="hidden id">{{ $item->id }}</p> {{-- surtout pas de CR dans cette ligne --}}

	<p class="hidden rang">
		rang : {{ $item->rang }}
	</p>
	<br /> {{-- pour chasser d'une ligne à cause des boutons --}}

</div>
@empty 
<h3>Aucun panier supprimé</h3>
@include('panier.button.index', ['etiquette' => 'Liste des paniers'])
@endforelse


<div id="paniers_index" class="offset3 span11 flexcontainer">

	@forelse($items as $item)

	<div class="portrait {{$item->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/panier/{{ $item->id }}/edit';">

		<p class="blanccalque66">{{ $item->type }}</p>
		<p  class="blanccalque75"><strong>{!! $item->nom_court !!}</strong></p>
		{{ $item->prix_commun }}
		<p class="blanccalque50">{!! $item->nom !!}</p>
		<p class="blanccalque50" style="font-style:italic">{!! $item->idee !!}</p>
		<p>{{ $item->remarques }}</p>

	</div>
	@empty 
	<h3>Aucun panier à la corbeille</h3>
	@endforelse

</div>

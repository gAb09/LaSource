@forelse($items as $item)
<div class="portrait {{$item->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/panier/{{ $item->id }}/edit';">

	<p class="lighten66">{{ $item->type }}<br />
		<strong>{!! $item->nom_court !!}</strong></p>
		<p class="" style="font-style:italic">{!! $item->idee !!}</p>
 		<p class="lighten50">{!! $item->nom !!}<br />
		<strong>{{ $item->prix_commun }}</strong>
		<p><small>{{ $item->remarques }}</small></p>
		<p class="hidden id">{{ $item->id }}</p>
		<p class="hidden rang">rang : {{ $item->rang }}</p>
	</div>
@empty 
	<h3>Aucun panier n’a été trouvé</h3>
@endforelse


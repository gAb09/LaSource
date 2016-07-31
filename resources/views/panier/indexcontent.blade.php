@forelse($items as $item)
<div style="position:relative" class="portrait {{$item->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/panier/{{ $item->id }}/edit';">
	<div class=" supp " onClick="confirm('Etes-vous sur de vouloir supprimer le panier \n\n{!! $item->nom_court !!}');alert('vraiment sur ?');">
	<i class="fa fa-btn fa-trash-o"></i>
</div>
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
	<p class="hidden id">
		{{ $item->id }}
	</p>
	<p class="hidden rang">
		rang : {{ $item->rang }}
	</p>
</div>
@empty 
<h3>Aucun panier n’a été trouvé</h3>
@endforelse


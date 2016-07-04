@foreach($paniers as $panier)
@if($panier->lied)
{{ $panier->pivot }}
<form class="form-inline" role="form" method="POST" action="{{ route('panierDetachLivraison', [$panier->id, $item->id]) }}">
	{!! csrf_field() !!}

<div class="flexcontainer choisirunpanier ombrable {{ $panier->lied }}">

	<button type="submit" class="btn btn-warning btn-xs">
		<i class="fa fa-btn fa-check"></i>Retirer ce panier
	</button>
	<div class"type">{{ $panier->type }}</div>	
	<div class="nom">{!! $panier->nom !!}</div>	
</div>
</form>
@else
<div class="flexcontainer choisirunpanier ombrable">

	<button type="button" class="btn btn-primary btn-xs">
		<i class="fa fa-btn fa-check"></i>Ajouter ce panier
	</button>
	<div class"type">{{ $panier->type }}</div>	
	<div class="nom">{!! $panier->nom !!}</div>	
</div>
@endif
@endforeach


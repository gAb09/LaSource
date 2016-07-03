@foreach($paniers as $panier)
@if($panier->lied)
<div class="flexcontainer choisirunpanier ombrable {{ $panier->lied }}">

	<button type="button" class="btn btn-warning btn-xs">
		<i class="fa fa-btn fa-check"></i>Retirer ce panier
	</button>
	<div class"type">{{ $panier->type }}</div>	
	<div class="nom">{!! $panier->nom !!}</div>	
</div>
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


@foreach($paniers as $panier)
@if($panier->lied)
<div class="flexcontainer choisirunpanier {{ $panier->lied }}">

	<button type="button" class="btn btn-warning btn-xs">
		<i class="fa fa-btn fa-check"></i>Délier ce panier
	</button>
	<div class"type">{{ $panier->type }}</div>	
	<div class="nom">{!! $panier->nom !!}</div>	
</div>
@else
<div class="flexcontainer choisirunpanier">

	<button type="button" class="btn btn-success btn-xs">
		<i class="fa fa-btn fa-check"></i>Lier ce panier
	</button>
	<div class"type">{{ $panier->type }}</div>	
	<div class="nom">{!! $panier->nom !!}</div>	
</div>
@endif
@endforeach


@foreach($paniers as $panier)
@if($panier->lied)
{{ $panier->pivot }}

<div class="flexcontainer choisirunpanier ombrable {{ $panier->lied }}">
	@include('livraison.includes.detachPanierForm')
	<div class"type">{{ $panier->type }}</div>	
	<div class="nom">{!! $panier->nom !!}</div>	
</div>
@else
<div class="flexcontainer choisirunpanier ombrable">
	@include('livraison.includes.attachPanierForm')
	<div class"type">{{ $panier->type }}</div>	
	<div class="nom">{!! $panier->nom !!}</div>	
</div>
@endif
@endforeach


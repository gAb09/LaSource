	@foreach($paniers as $panier)

	@if($panier->lied)

	<div class="flexcontainer choisirunpanier ombrable {{ $panier->lied }}" onClick="javascript:toggleLied(this)">
		<input type="checkbox" class="hidden form-control" name="resultat[]" checked="checked" value="{{ $panier->id }}">

		<div class"type">{{ $panier->type }}</div>	
		<div class="nom">{!! $panier->nom !!}</div>	
	</div>
	@else
	<div class="flexcontainer choisirunpanier ombrable" onClick="javascript:toggleLied(this)">
		<input type="checkbox" class="hidden form-control" name="resultat[]" value="{{ $panier->id }}">

		<div class"type">{{ $panier->type }}</div>	
		<div class="nom">{!! $panier->nom !!}</div>	
	</div>
	@endif
	@endforeach
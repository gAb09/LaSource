<form id="syncPaniers"  class="form-inline" role="form" method="POST" action="{{ route('livraisonSyncPaniers', [$model->id]) }}">
	{!! csrf_field() !!}
	@include('livraison.button.PanierSyncProducteurs')
	<div class="modemploi">
		Les paniers liés à cette livraison sont surlignés en vert. Un clic sur sa ligne ajoute/retire un panier.
	</div>
	@foreach($paniers as $panier)

	@if($panier->lied)

	<div class="flexcontainer choisirunpanier ombrable {{ $panier->lied }}" onClick="javascript:toggleLied(this)">
		<input type="checkbox" class="hidden form-control" name="panier_id[]" checked="checked" value="{{ $panier->id }}">

		<div class="type">{{ $panier->type }}</div>	
		<div class="nom">{!! $panier->nom !!}</div>	
	</div>
	@else
	<div class="flexcontainer choisirunpanier ombrable" onClick="javascript:toggleLied(this)">
		<input type="checkbox" class="hidden form-control" name="panier_id[]" value="{{ $panier->id }}">

		<div class="type">{{ $panier->type }}</div>	
		<div class="nom">{!! $panier->nom !!}</div>	
	</div>
	@endif
	@endforeach
	@include('livraison.button.PanierSyncProducteurs')

</form>
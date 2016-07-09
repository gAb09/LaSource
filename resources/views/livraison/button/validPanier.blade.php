<form class="form-inline" role="form" method="POST" action="{{ route('livraisonDetachPanier', [$item->id, $panier->id]) }}">
	{!! csrf_field() !!}

	<button type="submit" class="btn btn-success btn-xs">
		<i class="fa fa-btn fa-save"></i>Enregistrer pour cette livraison
	</button>
</form>

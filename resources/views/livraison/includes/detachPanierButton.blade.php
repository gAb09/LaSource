<form class="form-inline" role="form" method="POST" action="{{ route('livraisonDetachPanier', [$item->id, $panier->id]) }}">
	{!! csrf_field() !!}

	<button type="submit" class="btn btn-warning btn-xs">
		<i class="fa fa-btn fa-check"></i>Retirer ce panier
	</button>
</form>

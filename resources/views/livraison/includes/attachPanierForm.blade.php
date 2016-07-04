<form class="form-inline" role="form" method="POST" action="{{ route('panierAttacToLivraison', [$panier->id, $item->id]) }}">
	{!! csrf_field() !!}

	<button type="submit" class="btn btn-primary btn-xs">
		<i class="fa fa-btn fa-check"></i>Ajouter ce panier
	</button>
</form>

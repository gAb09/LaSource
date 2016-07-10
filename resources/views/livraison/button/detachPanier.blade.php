	<button type="button" class="btn btn-warning btn-xs" onClick="javascript:document.location.href='{{ route('livraisonDetachPanier', ['livraison' => $item->id, 'panier' => $panier->id]) }}';">
		<i class="fa fa-btn fa-unlink"></i>Retirer de cette livraison
	</button>
	

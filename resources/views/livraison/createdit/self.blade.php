<div>
	<h4 class="col-md-12">Les dates</h4><br />
</div>

<!-- date_cloture -->
<div>
	<p>Date de clôture :</p>
	<input type="hidden" id="date_cloture" name="date_cloture" value="{{ $item->date_cloture or old('date_cloture') }}">
	<input type="text" id="clotureEnClair" name="clotureEnClair" value=" {{ $item->clotureEnClair }}">
</div>

<!-- date_paiement -->
<div>
	<p>Date limite de paiement :</p>
	<input type="hidden" id="date_paiement" name="date_paiement" value="{{$item->date_paiement or old('date_paiement') }}">
	<input type="text" id="paiementEnClair" name="paiementEnClair" value=" {{ $item->paiementEnClair }}">
</div>

<!-- date_livraison -->
<div>
	<p>Date de livraison :</p>
	<input type="hidden" id="date_livraison" name="date_livraison" value="{{$item->date_livraison or old('date_livraison') }}">
	<input type="text" id="livraisonEnClair" name="livraisonEnClair" value=" {{ $item->livraisonEnClair }}">
</div>

<div>
		<button type="submit" class="btn btn-sm btn-success">
			<i class="fa fa-btn fa-save fa-lg"></i>Valider ces dates
		</button>
</div>



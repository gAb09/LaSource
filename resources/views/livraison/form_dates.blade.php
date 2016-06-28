<div>
	<h4 class="col-md-12">Les dates</h4><br />
	<button type="submit" class="btn btn-xs btn-success">
		<i class="fa fa-btn fa-check"></i>Enregistrer les dates
	</button>
</div>

<!-- date_cloture -->
<div>
	<p>Date de clôture</p>
	<input type="text" name="date_cloture" value="{{ $item->date_cloture or old('date_cloture') }}">
</div>

<!-- date_paiement -->
<div>
	<p>Date de limite de paiement</p>
	<input type="text" class="" name="date_paiement" value="{{ $item->date_paiement or old('date_paiement') }}">
</div>


<!-- date_livraison -->
<div>
	<p>Date de livraison</p>
	<input type="text" class="" name="date_livraison" value="{{ $item->date_livraison or old('date_livraison') }}">
</div>


<div>
	<h4 class="col-md-12">Les dates</h4><br />
	<button type="submit" class="btn btn-xs btn-success">
		<i class="fa fa-btn fa-check"></i>Valider les dates
	</button>
</div>

<!-- date_cloture -->
<div>
	<p>Date de clôture : {{ $item->date_cloture->formatLocalized('%e %B %Y') }}</p>
	<?php $date_cloture = $item->date_cloture->format('Y-m-d');?>
	<input type="text" name="date_cloture" value="{{ $date_cloture or old('date_cloture') }}">
</div>

<!-- date_paiement -->
<div>
	<p>Date de limite de paiement : {{ $item->date_paiement->formatLocalized('%e %B %Y') }}</p>
	<?php $date_paiement = $item->date_paiement->format('Y-m-d');?>
	<input type="text" class="" name="date_paiement" value="{{ $date_paiement or old('date_paiement') }}">
</div>


<!-- date_livraison -->
<div>
	<p>Date de livraison : {{ $item->date_livraison->formatLocalized('%e %B %Y') }}</p>
	<?php $date_livraison = $item->date_livraison->format('Y-m-d');?>
	<input type="text" class="" name="date_livraison" value="{{ $date_livraison or old('date_livraison') }}">
</div>


<p style="text-align:center"><b>Date de paiement</b><br />
	<span>{{ $item->date_paiement_enclair }}</span><br />
	(dans {{ $item->date_paiement_delai }} jours)<br />
	<input type="text" id="date_paiement" name="date_paiement" value="{{ $item->date_paiement }}">
</p>
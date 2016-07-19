<p style="text-align:center"><b>Date de paiement</b><br />
	<span id="date_paiement_enclair" >{{ $item->date_paiement_enclair }}</span><br />
	(<span id="date_paiement_delai" >{{$item->date_paiement_delai}}</span>)<br />
	<input type="text" id="date_paiement" name="date_paiement" value="{{ old('date_paiement', $item->date_paiement) }}">
</p>
	<input type="hidden" id="datepicker_paiement" name="datepicker_paiement" value="">

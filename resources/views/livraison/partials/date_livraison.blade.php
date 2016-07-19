<p style="text-align:center"><b>Date de livraison</b><br />
	<span>{{ $item->date_livraison_enclair }}</span><br />
	(dans {{ $item->date_livraison_delai }} jours)<br />
	<input type="text" id="date_livraison" name="date_livraison" value="{{ old('date_livraison', $item->date_livraison) }}">
</p>

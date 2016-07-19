    @if ($errors->has('date_livraison'))
    <p class="alert alert-danger style="text-align:center"">
        {{ $errors->first('date_livraison') }}
    @else
<p style="text-align:center"><b>Date de livraison</b>
	@endif
	<br />
	<span id="date_livraison_enclair" >{{ $item->date_livraison_enclair }}</span><br />
	(<span id="date_livraison_delai" >{{$item->date_livraison_delai}}</span>)<br />
	<input type="text" id="date_livraison" name="date_livraison" value="{{ old('date_livraison', $item->date_livraison) }}">
</p>
	<input type="hidden" id="datepicker_livraison" name="datepicker_livraison" value="">


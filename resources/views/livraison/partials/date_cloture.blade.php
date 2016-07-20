    @if ($errors->has('date_cloture'))
    <p style="text-align:center">
        <b>{{ $errors->first('date_cloture') }}</b>
    @else
<p style="text-align:center"><b>Date de clôture</b>
	@endif
	<br />
	<span id="date_cloture_enclair" >{{ $item->date_cloture_enclair }}</span><br />
	(<span id="date_cloture_delai" >{{$item->date_cloture_delai}}</span>)<br />
	<input type="hidden" id="date_cloture" name="date_cloture" value="{{ old('date_cloture', $item->date_cloture) }}">
</p>
	<input type="hidden" id="datepicker_cloture" name="datepicker_cloture" value="">





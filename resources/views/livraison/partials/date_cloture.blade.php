    @if ($errors->has('date_cloture'))
    <p style="text-align:center">
        <b>{!! $errors->first('date_cloture') !!}</b>
    @else
<p style="text-align:center"><b>Date de clôture</b>
	@endif
	<br />
	<span id="date_cloture_enclair" >@date_complete($model->date_cloture)</span><br />
	(<span id="date_cloture_delai" >{{$model->date_cloture_delai}}</span>)<br />
	<input type="hidden" id="date_cloture" name="date_cloture" value="{{ old('date_cloture', $model->date_cloture) }}">
</p>
	<input type="hidden" id="datepicker_cloture" name="datepicker_cloture" value="">





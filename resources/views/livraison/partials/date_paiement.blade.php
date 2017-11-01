    @if ($errors->has('date_paiement'))
    <p style="text-align:center">
        <b>{!! $errors->first('date_paiement') !!}</b>
    @else
<p style="text-align:center"><b>Date limite de paiement</b>
	@endif
	<br />
	@if($mode == 'edit')
		<span id="date_paiement_enclair" >@date_complete($model->date_paiement)</span><br />
	@else
		<span id="date_paiement_enclair" >(- - -)</span><br />
	@endif
	(<span id="date_paiement_delai" >{{$model->date_paiement_delai}}</span>)<br />
	<input type="hidden" id="date_paiement" name="date_paiement" value="{{ old('date_paiement', $model->date_paiement) }}">
</p>
	<input type="hidden" id="datepicker_paiement" name="datepicker_paiement" value="">
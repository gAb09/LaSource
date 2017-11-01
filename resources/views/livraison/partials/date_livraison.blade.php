    @if ($errors->has('date_livraison'))
    <p style="text-align:center">
        <b>{!! $errors->first('date_livraison') !!}</b>
    @else
<p style="text-align:center"><b>Date de livraison</b>
	@endif
	<br />
	@if($mode == 'edit')
		<span id="date_livraison_enclair" >@date_complete($model->date_livraison)</span><br />
	@else
		<span id="date_livraison_enclair" >(- - -)</span><br />
	@endif
	(<span id="date_livraison_delai" >{{$model->date_livraison_delai}}</span>)<br />
	<input type="hidden" id="date_livraison" name="date_livraison" value="{{ old('date_livraison', $model->date_livraison) }}">
</p>
	<input type="hidden" id="datepicker_livraison" name="datepicker_livraison" value="">
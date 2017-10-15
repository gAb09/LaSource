<h5>Mode de paiement</h5>
<div class="modepaiement flexcontainer">
	@foreach($modespaiement as $mode)
		<input class="hidden" type="txt" name="{{ $ref_livraison }}_paiement" value="{{ $mode->id }}">
		<span class="btn btn-info btn-xs" name="{{ $mode->nom }}" contexte="{{$ref_livraison}}" onClick="javascript:select(this);">{{ $mode->nom }} </span>
	@endforeach
</div>

<h5>Relais</h5>
<div class="relais flexcontainer">
	@foreach($relaiss as $relais)
		<input class="hidden" type="txt" name="{{ $ref_livraison }}_relais" value="{{ $relais->id }}">
		<span class="btn btn-info btn-xs" name="{{ $relais->nom }}" contexte="{{$ref_livraison}}" onClick="javascript:select(this);">{{ $relais->ville}} - {{$relais->nom }} </span>
	@endforeach
</div>
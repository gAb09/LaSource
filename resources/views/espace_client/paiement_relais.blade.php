<h5>Mode de paiement</h5>
<div class="modepaiement flexcontainer">
	<input class="hidden" type="txt" name="{{ $ref_livraison }}_paiement" value="">
	@foreach($modespaiement as $mode)
	<span class="btn-xs" model="paiement" name="{{ $mode->nom }}" livraison="{{$ref_livraison}}" 
		onClick="javascript:select('{{$ref_livraison}}', 'paiement', this, {{ $mode->id }});">{{ $mode->nom }}
	</span>
	@endforeach
</div>

<h5>Relais</h5>
<div class="relais flexcontainer">
	<input class="hidden" type="txt" name="{{ $ref_livraison }}_relais" value="">
	@foreach($relaiss as $relais)
	<span class="btn-xs" model="relais" name="{{ $relais->nom }}" livraison="{{$ref_livraison}}" 
		onClick="javascript:select('{{$ref_livraison}}', 'relais', this, {{ $relais->id }});">{{ $relais->nom }}
	</span>
	@endforeach
</div>
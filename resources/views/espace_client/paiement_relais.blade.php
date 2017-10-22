<h5>Mode de paiement {{$par_defaut}}</h5>
<div class="modepaiement flexcontainer">
	<input class="hidden" type="txt" name="{{ $ref_livraison }}_paiement" value="{{$model->client->pref_paiement}}">
	@foreach($modespaiement as $mode)
	<span class="btn-xs {{$mode->checked}}" model="paiement" name="{{ $mode->nom }}" livraison="{{$ref_livraison}}" 
		onClick="javascript:becomeSelected(this, {{ $mode->id }});">{{ $mode->nom }}
	</span>
	@endforeach
</div>

<h5>Relais {{$par_defaut}}</h5>
<div class="relais flexcontainer">
	<input class="hidden" type="txt" name="{{ $ref_livraison }}_relais" value="{{$model->client->pref_relais}}">
	@foreach($relaiss as $relais)
	<span class="btn-xs {{$relais->checked}}" model="relais" name="{{ $relais->nom }}" livraison="{{$ref_livraison}}" 
		onClick="javascript:becomeSelected(this, {{ $relais->id }});">{{ $relais->nom }}
	</span>
	@endforeach
</div>
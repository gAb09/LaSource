<h5 class="groupe_preference_client">Mode de paiement {{$par_defaut}}</h5>
<div class="modepaiement flexcontainer">
	<input class="hidden" type="txt" name="{{ $ref_livraison }}_paiement" value="{{ $paiement_initial }}">
		@if (is_null($paiement_initial))
			<p class="nopref">Aucune préférence n’est définie</p>
		@endif

	@foreach($modespaiement as $mode)
		<?php
		if ($mode->id == $paiement_initial) {
			$mode->checked = "checked";
		}else{
			$mode->checked = "";
		}
		?>


	<span class="btn-xs {{$mode->checked}}" model="paiement" name="{{ $mode->nom }}" livraison="{{$ref_livraison}}" 
		onClick="javascript:becomeSelected(this, {{ $mode->id }});">{{ $mode->nom }}
	</span>
	@endforeach
</div>




<h5 class="groupe_preference_client">Relais {{$par_defaut}}</h5>
<div class="relais flexcontainer">
	<input class="hidden" type="txt" name="{{ $ref_livraison }}_relais" value="{{$relais_initial}}">

		@if (is_null($relais_initial))
			<p class="nopref">Aucune préférence n’est définie</p>
		@endif

	@foreach($relaiss as $relais)
		<?php
		if ($relais->id == $relais_initial) {
			$relais->checked = "checked";
		}else{
			$relais->checked = "";
		}
		?>


	<span class="btn-xs {{$relais->checked}}" model="relais" name="{{ $relais->nom }}" livraison="{{$ref_livraison}}" 
		onClick="javascript:becomeSelected(this, {{ $relais->id }});">{{ $relais->nom }}
	</span>
	@endforeach
</div>
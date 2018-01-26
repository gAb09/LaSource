<h5 class="groupe_preference_client">Mode de paiement {{$par_defaut}}</h5>
<div class="modepaiement flexcontainer">
	<input class="hidden" type="txt" name="{{ $ref_livraison }}_paiement" value="{{ $paiement_selected }}">

	@if(is_null($paiement_selected))
		<p role="nopref" model="paiement" class="nopref">@lang('message.client.nopref')</p>
		@if($ref_livraison !==0)
			<p role="fav_not_lied" model="paiement" livraison="{{ $ref_livraison }}" class="hidden fav_not_lied">@lang('message.client.paiementfav_indispo')</p>
		@endif
	@else
		<p role="nopref" model="paiement" class="hidden nopref">@lang('message.client.nopref')</p>
		@if($ref_livraison !==0)
			@if($prefpaiement_not_lied)
				@php
					$hidden = '';
				@endphp
			@else
				@php
					$hidden = 'hidden';
				@endphp
			@endif
		<p role="fav_not_lied" model="paiement" livraison="{{ $ref_livraison }}" class="{{$hidden or 'hidden'}} fav_not_lied">@lang('message.client.paiementfav_indispo')</p>
		@endif
	@endif


	@foreach($modespaiement as $mode)
		<?php
		if ($mode->id == $paiement_selected) {
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
	<input class="hidden" type="txt" name="{{ $ref_livraison }}_relais" value="{{$relais_selected}}">

	@if(is_null($relais_selected))
		<p role="nopref" model="relais" class="nopref">@lang('message.client.nopref')</p>
		@if($ref_livraison !==0)
			<p role="fav_not_lied" model="relais" livraison="{{ $ref_livraison }}" class="hidden fav_not_lied">@lang('message.client.relaisfav_indispo')</p>
		@endif
	@else
		<p role="nopref" model="relais" class="hidden nopref">@lang('message.client.nopref')</p>
		@if($ref_livraison !==0)
			@if($prefrelais_not_lied)
				@php
					$hidden = '';
				@endphp
			@else
				@php
					$hidden = 'hidden';
				@endphp
			@endif
		<p role="fav_not_lied" model="relais" livraison="{{ $ref_livraison }}" class="{{$hidden or 'hidden'}} fav_not_lied">@lang('message.client.relaisfav_indispo')</p>
		@endif
	@endif



	@foreach($relaiss as $relais)
		<?php
		if ($relais->id == $relais_selected) {
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
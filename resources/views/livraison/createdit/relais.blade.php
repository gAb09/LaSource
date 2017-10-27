<div>
	<h4 class="SsTitre">Les relais</h4>
</div>

@forelse($relaiss as $relais)
<div class="relaiscontainer {{$relais->statut}}">
		<div class="liaison" style="margin-bottom:5px;">
			<input id="input_{{ $relais->id }}" type="hidden" name="is_lied[{{ $relais->id }}]" value="{{$relais->is_lied}}">
			<input type="hidden" name="liaison[{{ $relais->id }}]" value="{{$relais->liaison}}">
		
			<!-- Si relais disponible pour cette date de livraison et non retiré -->
			@if($relais->is_lied == 1) 
				<input type="text" id="flagLied" class="form-control LiedWIthThisLivraison" value="Lié à cette livraison">
				<button class="form-control btn btn-info toggle" onClick="javascript:detachRelais({{$relais->id}});">
				Délier
				</button>
			@else
				<input type="text" id="flagLied" class="form-control" value="Non lié à cette livraison">
				<button class="form-control btn btn-info toggle" onClick="javascript:attachRelais({{$relais->id}});return false;">
				Lier
				</button>
			@endif
		</div>
	<p>
		<span class="gras ville">{{ $relais->ville }}</span><br/>
		<span class="gras">{{ $relais->nom }}</span><br/>
		{{ $relais->tel }}<br/>
		{{ $relais->email }}
	</p>
	@forelse($relais->indisponibilites as $indisponibilite)
		<p name="{{$indisponibilite->statut}}_{{ $relais->id }}" class="indispo {{$indisponibilite->statut}}">
			<span class="premiere gras">Indisponible pour cause de</span><br/>
			<span class="gras">{{ $indisponibilite->cause }}</span><br/>
			du @date_longue($indisponibilite->date_debut)<br />au @date_longue($indisponibilite->date_fin)
		</p>
	@empty
	@endforelse

	
</div>
@empty
	No relais
@endforelse
<div>
	<h4 class="SsTitre">Les relais</h4>
</div>

@forelse($relaiss as $relais)
<div class="relaiscontainer {{$relais->statut}}">
		<div style="margin-bottom:5px;">
			<input id="input_{{ $relais->id }}" type="hidden" name="is_retired[{{ $relais->id }}]" value="{{$relais->is_retired}}">
		
			<!-- Si relais disponible pour cette date de livraison et non retiré -->
			@if($relais->is_lied == 1) 
			<input type="text" id="flagLied" class="form-control LiedWIthThisLivraison" value="Retirer de cette livraison"
			onClick="javascript:var target = getElementById('input_{{ $relais->id }}');target.value=1;console.log(target.id);submit();"
			>
			@else
			<input type="text" id="flagLied" class="form-control" value="Associer à cette livraison"
			onClick="javascript:var target = getElementById('input_{{ $relais->id }}');target.value=0;console.log(target.id);submit();"
			>
			@endif
		</div>
	<p>
		<span class="gras ville">{{ $relais->ville }}</span><br/>
		<span class="gras">{{ $relais->nom }}</span><br/>
		{{ $relais->tel }}<br/>
		{{ $relais->email }}
	</p>
	@forelse($relais->indisponibilites as $indisponibilite)
		<p class="indispo {{$indisponibilite->statut}}">
			<span class="premiere gras">Indisponible pour cause de</span><br/>
			<span class="gras">{{ $indisponibilite->cause }}</span><br/>
			du {{ $indisponibilite->date_debut_enclair }}<br />au {{ $indisponibilite->date_fin_enclair }}
		</p>
	@empty
	@endforelse

	

	</div>
@empty
	No relais
@endforelse
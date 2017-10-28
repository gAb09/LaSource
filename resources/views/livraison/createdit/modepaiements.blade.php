<div>
	<h4 class="SsTitre">Les modes de paiement</h4>
</div>

@forelse($modepaiements as $modepaiement)
<div class="modepaiementcontainer {{$modepaiement->statut}}">
		<div class="liaison" style="margin-bottom:5px;">
			<input id="input_modepaiement_{{ $modepaiement->id }}" type="hidden" name="is_lied[{{ $modepaiement->id }}]" value="{{$modepaiement->is_lied}}">
			<input type="hidden" name="liaison[{{ $modepaiement->id }}]" value="{{$modepaiement->liaison}}">
		
			<!-- Si modepaiement disponible pour cette date de livraison et non retiré -->
			@if($modepaiement->is_lied == 1) 
				<input type="text" id="flagLied" class="form-control LiedWIthThisLivraison" value="Lié à cette livraison">
				<button class="form-control btn btn-info toggle" onClick="javascript:detachModepaiement({{$modepaiement->id}});">
				Délier
				</button>
			@else
				<input type="text" id="flagLied" class="form-control" value="Non lié à cette livraison">
				<button class="form-control btn btn-info toggle" onClick="javascript:attachModepaiement({{$modepaiement->id}});return false;">
				Lier
				</button>
			@endif
		</div>
	<p>
		<span class="gras">{{ $modepaiement->nom }}</span><br/>
	</p>
	@forelse($modepaiement->indisponibilites as $indisponibilite)
		<p name="{{$indisponibilite->statut}}_{{ $modepaiement->id }}" class="indispo {{$indisponibilite->statut}}">
			<span class="premiere gras">Indisponible pour cause de</span><br/>
			<span class="gras">{{ $indisponibilite->cause }}</span><br/>
			du {@date_complete($indisponibilite->date_debut)<br />au @date_complete($indisponibilite->date_fin)
		</p>
	@empty
	@endforelse

	
</div>
@empty
	Aucun mode de paiement n’est accessible
@endforelse
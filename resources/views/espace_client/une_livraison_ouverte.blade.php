<h4 class="" style="background-color:white;padding:10px;margin:0 8px"><span id="modification_livraison" class=""  ></span>Livraison du @date_complete($livraison->date_livraison)
	<small>ouverte jusqu'au @date_complete($livraison->date_cloture) et payable avant le @date_complete($livraison->date_paiement)</small>
</h4>
@if($livraison->remarques)<p class="remarques">{{$livraison->remarques}}</p>@endif

@if(!$livraison->panier->isEmpty())
	<div class="flexcontainer">
	@foreach($livraison->panier as $panier)
		<div class="panierDeLivraisonOuverte flexcontainer">
			<p class="type">
				{{ $panier->type }}
			</p>
			<p>
				@nobr($panier->nom)
			</p>
			<p style="font-style:italic">
				{{$panier->exploitation}}
			</p>
			<p  class="prix_panier">
				<span name="{{$panier->id}}_prix_panier_enclair" class="prix">@prixFR($panier->pivot->prix_livraison)</span>
				<span name="{{$panier->id}}_prix_panier" class="hidden"> {{ $panier->pivot->prix_livraison }}</span>
			</p>
			<p>
				<small>@nobr($panier->idee)</small>
			</p>
			<div class="quantite">
				<?php
				if (!is_null(old($livraison->id."_qte_".$panier->id))){
					$valeur = old($livraison->id."_qte_".$panier->id);
				}elseif(!is_null($panier->quantite)){
					$valeur = $panier->quantite;
				}else{
					$valeur = 0;
				}
				?>

				<span class="fleche decrement" onclick="javascript:decrement({{$livraison->id}}, {{$panier->id}});"><i class="fa fa-angle-double-down"></i></span>
				<span class="fleche increment" onclick="javascript:increment({{$livraison->id}}, {{$panier->id}});"><i class="fa fa-angle-double-up"></i></span>
				<input type="txt" class="" name="{{ $livraison->id }}_qte_{{ $panier->id }}" value="{{$valeur}}" onBlur="javascript:qteChange(this, {{$livraison->id}}, {{$panier->id}})">
			<br />
			</div>
				<p class="total_panier" name="{{$livraison->id}}_total_panier_{{$panier->id}}" >non commandé</p>
		</div>
	@endforeach


	<div class="paiement_relais">
		@include('espace_client.paiement_relais', [
		'paiement_selected' => $livraison->paiement_selected, 
		'relais_selected' => $livraison->relais_selected, 
		'prefrelais_not_lied' => $livraison->prefrelais_not_lied, 
		'prefpaiement_not_lied' => $livraison->prefpaiement_not_lied, 
		'ref_livraison' => $livraison->id, 
		'par_defaut' => '', 
		'modespaiement' => $livraison->Modepaiements, 
		'relaiss' => $livraison->relais]
		)
	</div>
	</div>
		<p  name="{{$livraison->id}}_total_livraison" class="total_livraison">
			Aucun panier commandé
		</p>
@else
	<p class="is_error_txt">
		Tiens ! Aucun panier n'est prévu ??
	</p>
@endif


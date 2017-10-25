<h4 class="">Livraison du {{$livraison->date_livraison_enclair}}
	<small>ouverte jusqu'au {{$livraison->date_cloture_enclair}} et payable avant le {{$livraison->date_paiement_enclair}}</small>
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
				{{ $panier->nom_nobr }}
			</p>
			<p style="font-style:italic">
				{{$panier->exploitation}}
			</p>
			<p  class="prix_panier">
				<span name="{{$panier->id}}_prix_panier" class="prix">{{$panier->pivot->prix_livraison}}</span> euros
			</p>
			<p>
				<small>{!! $panier->idee_nobr !!}</small>
			</p>
			<div class="quantite">
				<span class="fleche decrement" onclick="javascript:decrement({{$livraison->id}}, {{$panier->id}});"><i class="fa fa-angle-double-down"></i></span>
				<span class="fleche increment" onclick="javascript:increment({{$livraison->id}}, {{$panier->id}});"><i class="fa fa-angle-double-up"></i></span>
				<input type="txt" class="" name="{{ $livraison->id }}_qte_{{ $panier->id }}" value="0" onBlur="javascript:qteChange(this, {{$livraison->id}}, {{$panier->id}})">
			<br />
			</div>
				<p class="total_panier" name="{{$livraison->id}}_total_panier_{{$panier->id}}" >non commandé</p>
		</div>
	@endforeach
	<div class="paiement_relais">
		@include('espace_client.paiement_relais', ['ref_livraison' => $livraison->id, 'par_defaut' => ''])
	</div>
	</div>
		<p  name="{{$livraison->id}}_total_livraison" class="total_livraison">
			Aucune commande
		</p>
@else
	<p class="is_error_txt">
		Tiens ! Aucun panier n'est prévu ??
	</p>
@endif


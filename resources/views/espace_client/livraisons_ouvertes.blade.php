<h4 class="">Livraison du {{$livraison->date_livraison_enclair}}
	<small>ouverte jusqu'au {{$livraison->date_cloture_enclair}} et payable avant le {{$livraison->date_paiement_enclair}}</small>
</h4>

@if(!$livraison->panier->isEmpty())
<div class="flexcontainer">
	@foreach($livraison->panier as $panier)
	<div class="panierDeLivraisonOuverte" livraison="{{$livraison->id}}" panier="{{$panier->id}}">
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
			<span class="prix">{{$panier->pivot->prix_livraison}}</span> euros
		</p>
		<p>
			<small>{!! $panier->idee_nobr !!}</small>
		</p>
		<div class="quantite">
			<span class="fleche decrement" onclick="javascript:decrement(this);">–</span>
			<span class="fleche increment" onclick="javascript:increment(this);">+</span>
			<input type="txt" class="" name="{{ $livraison->id }}_{{ $panier->id }}" $value="0" onChange="javascript:qteChange(this)">
			<br />
		</div>
		<p class="total_panier">=</p>
	</div>
	@endforeach
	<div class="paiement_relais">
		@include('espace_client.paiement_relais', ['ref_livraison' => $livraison->id, 'par_defaut' => ''])
	</div>
</div>
<p class="total_livraison" style="display:inline">
	Total livraison : 
</p>
@else
<p class="is_error_txt">
	Tiens ! Aucun panier n'est prévu ??
</p>
@endif


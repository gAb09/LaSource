@forelse($livraisons as $livraison)
	<h4 class="">Livraison du {{$livraison->date_livraison_enclair}}
		<small>ouverte jusqu'au {{$livraison->date_cloture_enclair}} et payable avant le {{$livraison->date_paiement_enclair}}</small>
	</h4>

	<div class="flexcontainer">
	<!-- h5>Les paniers proposés :</h5-->
	@if(!$livraison->panier->isEmpty())
		@foreach($livraison->panier as $panier)
			<div>
				<p>
					{{ $panier->type }}<br />{{ $panier->nom_sans_retours }}
				</p>
				<p style="font-style:italic">
					{{$panier->exploitation}}
				</p>
				<p>
					{{$panier->pivot->prix_livraison}} euros
				</p>
				<p>
					<small>{!! $panier->idee !!}</small>
				</p>
				<p>
					<input name="{{ $livraison->id }}_{{ $panier->id }}" type="txt">
				</p>
			</div>
		@endforeach
			<div class="paiement_relais">
				@include('espace_client.paiement_relais', ['ref_livraison' => $livraison->id])
			</div>
	@else
		<p class="is_error_txt">
			Tiens ! Aucun panier n'est prévu ??
		</p>
	@endif

	</div>

@empty
	À ce jour, pas de livraison programmée

@endforelse

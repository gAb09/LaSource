<!-- Les dates -->
<div class="col-md-12 flexcontainer edit_show_livraison showdates">
	<div>
		<h4>Les dates</h4>
	</div>

	<!-- date_cloture -->
	<p style="text-align:center"><b>Date de clôture</b>
		<br />
		<span id="date_cloture_enclair" >@date_complete($model->date_cloture)</span><br />
		(<span id="date_cloture_delai" >{{$model->date_cloture_delai}}</span>)<br />
		<input type="hidden" id="date_cloture" name="date_cloture" value="{{ old('date_cloture', $model->date_cloture) }}">
	</p>


	<!-- date_paiement -->
	<p style="text-align:center"><b>Date limite de paiement</b>
		<br />
		<span id="date_paiement_enclair" >@date_complete($model->date_paiement)</span><br />
		(<span id="date_paiement_delai" >{{$model->date_paiement_delai}}</span>)<br />
		<input type="hidden" id="date_paiement" name="date_paiement" value="{{ old('date_paiement', $model->date_paiement) }}">
	</p>


	<!-- date_livraison -->
	<p style="text-align:center"><b>Date de livraison</b>
		<br />
		<span id="date_livraison_enclair" >@date_complete($model->date_livraison)</span><br />
		(<span id="date_livraison_delai" >{{$model->date_livraison_delai}}</span>)<br />
		<input type="hidden" id="date_livraison" name="date_livraison" value="{{ old('date_livraison', $model->date_livraison) }}">
	</p>

	<!-- <p> = bloc fantôme pour décaler les div en flex -->
	<p>
	</p>
</div>



<!-- Les paniers -->
<div class="col-md-12 flexcontainer edit_show_livraison showpaniers">
	<h4 class="SsTitre">Les paniers</h4>

	<table class="paniers_lied col-md-9">
		<thead>
			<tr>
				<th class="nomcourt">
					Nom du panier
				</th>
				<th class="producteur">
					Producteur pour cette livraison
				</th>
				<th class="prixlivraison">
					Prix pour cette livraison
				</th>

		<tbody>
			@forelse($model->Panier as $panier)
			<tr>
				<!-- nom_court -->
				<td class="nomcourt">
					{!! $panier->type !!} / {!! $panier->nom_court !!}
				</td>


				<!-- producteur -->
				<td class="form-group">
				@foreach($panier->producteur as $producteur)
					@if($producteur->id == $panier->pivot->producteur)
						{{ $producteur->nompourpaniers }}
					@endif
				@endforeach
				</td>

				<!-- prix livraison-->
				<td class="form-group">
					{{ $panier->pivot->prix_livraison }}
				</td>
			</tr>
			@empty
				Aucun panier trouvé
			@endforelse
		</tbody>
	</table>
</div>



<!-- Les relais -->
<div class="col-md-12 flexcontainer edit_show_livraison showrelaiss">
<div>
	<h4 class="SsTitre">Les relais</h4>
</div>

@forelse($relaiss as $relais)
<div class="relaiscontainer {{$relais->statut}}">
	<p>
		<span class="gras ville">{{ $relais->ville }}</span><br/>
		<span class="gras">{{ $relais->nom }}</span><br/>
		{{ $relais->tel }}<br/>
		{{ $relais->email }}
	</p>
</div>
@empty
	No relais
@endforelse
	<!-- <p> = bloc fantôme pour décaler les div en flex -->
	<p></p>
	<p></p>
</div>



<!-- Les modes de paiement -->
<div class="col-md-12 flexcontainer edit_show_livraison showmodepaiements">
<div>
	<h4 class="SsTitre">Les modes de paiement</h4>
</div>

@forelse($modepaiements as $modepaiement)
<div class="modepaiementcontainer {{$modepaiement->statut}}">
	<p>
		<span class="gras">{{ $modepaiement->nom }}</span><br/>
	</p>
</div>
@empty
	Aucun mode de paiement n’est accessible
@endforelse
	<!-- <p> = bloc fantôme pour décaler les div en flex -->
	<p></p>
	<p></p>
</div>

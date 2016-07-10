	<h4 class="">Les paniers</h4>



	<table class="panierschoisis col-md-9">
		<tbody>
			@forelse($item->Panier as $panier)
			<tr class="unpanierchoisi">

				<td style="width:10px">
					<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ModalEditPanier">
						<i class="fa fa-btn fa-edit fa-lg"></i>{{ $panier->id }}
					</a>

					<!-- panier id -->
					<input type="hidden" class="id" name="panier_id[]" value="{{ $panier->id or old('panier_id') }}">

				</td>
				<!-- type
				<td style="width:150px">
					{{ $panier->type }}
				</td>	 -->

				<!-- nom_court -->
				<td style="width:150px">
					{!! $panier->nom_court !!}
				</td>

				<!-- producteur -->
				<td>
					<select name="producteur[]">
						@forelse($panier->producteur as $producteur)
						<option value="{!! $producteur->nompourpaniers !!}">{!! $producteur->nompourpaniers !!}</option>
						@empty
						<option value="Indéterminé">Indéterminé</option>
						@endforelse
					</select>
					<div>
						<a class="btn btn-xs" onClick="javascript:listProducteursForPanier({{$panier->id}})" data-toggle="modal" data-target="#ModallistProducteursForPanier">
							<i class="fa fa-btn fa-edit"></i>
							Modifier la liste
						</a>
					</div>
				</td>

				<!-- prix livraison-->
				<td>
					Prix livraison
					<input type="text" class="prixlivraison" name="prix_livraison[]" value="{{ $panier->pivot->prix_livraison or old('prix_livraison') }}">
				</td>

				<!-- prix commun-->
				<td>				
					Prix base
					<input type="text" class="prix" name="prix_commun[]" value="{{ $panier->prix_commun or old('prix_commun') }}" onClick="javascript:reporterValeur(this)">
					</td>
					<td>
						<button type="button" class="btn btn-warning btn-xs" onClick="javascript:document.location.href='{{ route('livraisonDetachPanier', ['livraison' => $item->id, 'panier' => $panier->id]) }}';">
							<i class="fa fa-btn fa-unlink fa-lg"></i>Retirer de cette livraison
						</button>
					</td>

					@empty

					<h4>Aucun panier n’est encore lié à cette livraison</h4>

				</tr>
				@endforelse
			</tbody>
		</table>


		<!-- Button trigger modal -->
		<div class="boutonspaniers flexcontainer" >

			<button type="submit" class="btn btn-success btn-xs">
				<i class="fa fa-btn fa-save"></i> <br />Valider ces paniers
			</button>

			<button type="button" class="btn btn-primary btn-xs" onClick="javascript:listPaniers({{$item->id}})" data-toggle="modal" data-target="#ModallistPaniers">
				<i class="fa fa-btn fa-shopping-basket"></i> <br />Ajouter des paniers
			</button>

		</div>
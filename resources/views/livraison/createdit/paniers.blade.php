<div class="">
	<h4 class="col-md-12">Les paniers</h4><br />
</div>

<form class="form-inline" role="form" method="POST" action="{{ route('livraisonSyncPaniers', [$item->id]) }}">
	{!! csrf_field() !!}



	<table class="panierschoisis col-md-10">
		<tbody>
			@forelse($item->Panier as $panier)
			<tr class="unpanierchoisi">

				<td>
					<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ModalEditPanier">
						<i class="fa fa-btn fa-edit"></i>Éditer panier n° {{ $panier->id }}
					</a>

					<!-- panier id -->
					<input type="hidden" class="id" name="panier_id[]" value="{{ $panier->id or old('panier_id') }}">

				</td>
				<!-- type -->
				<td>{{ $panier->type }}</td>	

				<!-- nom_court -->
				<td>
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
					<input type="text" class="prix" name="prix_commun[]" value="{{ $panier->prix_commun or old('prix_commun') }}">
				</td>
				<td>				
					Prix commun
					<input type="text" class="prix" name="prix_livraison[]" value="{{ $panier->pivot->prix_livraison or old('prix_livraison') }}">
				</td>
				<td>
					@include('livraison.button.detachPanier')
					@include('livraison.button.syncPanier')
				</td>

				@empty

				<h4>Aucun panier n’est encore lié à cette livraison</h4>

			</tr>
			@endforelse
		</tbody>
	</table>

</form>

	<div class="panierschoisis col-md-2 col-md-offset-10">

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" onClick="javascript:listPaniers({{$item->id}})" data-toggle="modal" data-target="#ModallistPaniers">
	<i class="fa fa-btn fa-shopping-basket"></i>Ajouter des paniers
</button>
</div>






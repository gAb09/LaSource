<div class="">
	<h4 class="col-md-12">Les paniers</h4><br />
</div>

<table class="panierschoisis col-md-8">
	<tbody>
		@forelse($item->Panier as $panier)
		<tr class="unpanierchoisi">

			<td>
				<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ModalEditPanier">
					<i class="fa fa-btn fa-edit"></i>Éditer panier
				</a>

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

			<!-- prix -->
			<td>
				Prix
				<input type="text" class="prix" name="prix_commun[]" value="{{ $panier->prix_commun or old('prix_commun') }}">
			</td>
			<td>
				@include('livraison.button.detachPanier')
				@include('livraison.button.validPanier')
			</td>

		@empty

		<h4>Aucun panier n’est encore lié à cette livraison</h4>

		</tr>
		@endforelse
	</tbody>
</table>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" onClick="javascript:listPaniers({{$item->id}})" data-toggle="modal" data-target="#ModallistPaniers">
	<i class="fa fa-btn fa-shopping-basket"></i>Ajouter des paniers
</button>






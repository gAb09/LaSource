@section('modal')
@include('livraison.ModalChoixPaniers')
@include('livraison.ModalEditPanier')
@show

<div class="">
	<h4 class="col-md-12">Les paniers</h4><br />
</div>

<table class="panierschoisis col-md-8">
	<tbody>
		@forelse($item->Panier as $panier)
		<tr class="unpanierchoisi">
			<td>{{ $panier->type }}</td>	

			<td>{!! $panier->nom_court !!}</td>

			<td>
				<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ModalEditPanier">
					<i class="fa fa-btn fa-edit"></i>Edit
				</button>
				<select name="producteur[]">
					@forelse($panier->producteur as $producteur)
					<option value="{!! $producteur->nompourpaniers !!}">{!! $producteur->nompourpaniers !!}</option>
					@empty
					<option value="Indéterminé">Indéterminé</option>
					@endforelse
				</select>
			</td>

			<td>
				Prix
				<input type="text" name="prix_commun[]" value="{{ $panier->prix_commun or old('prix_commun') }}">
			</td>

			<td>
				<button type="button" class="btn btn-warning btn-xs">
					<i class="fa fa-btn fa-unlink"></i>Retirer ce panier
				</button>
			</td>
		</tr>

		@empty

		<h4>Aucun panier n’est encore lié à cette livraison</h4>

		@endforelse
	</tbody>
</table>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalChoixPaniers">
	<i class="fa fa-btn fa-shopping-basket"></i>Ajouter d’autres paniers
</button>


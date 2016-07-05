@section('modal')
@include('livraison.modales.ChoixPaniers')
@include('livraison.modales.EditPanier')
<div class="modal fade" id="ModalChoixProducteurs" tabindex="-1" role="dialog" aria-labelledby="ModalChoixProducteursLabel">
</div>
@show

<div class="">
	<h4 class="col-md-12">Les paniers{{$item->id}}</h4><br />
</div>

<table class="panierschoisis col-md-8">
	<tbody>
		<tr class="unpanierchoisi">
		@forelse($item->Panier as $panier)

			<td>
				<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ModalEditPanier">
					<i class="fa fa-btn fa-edit"></i>Modifier <br />ce panier
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
					<a class="btn btn-xs" onClick="javascript:ModalChoixProducteurs({{$panier->id}})" data-toggle="modal" data-target="#ModalChoixProducteurs">
						<i class="fa fa-btn fa-edit"></i>
						Modifier la liste
					</a>
				</div>
			</td>

			<!-- prix -->
			<td>
				Prix
				<input type="text" name="prix_commun[]" value="{{ $panier->prix_commun or old('prix_commun') }}">
			</td>
			<td>
				@include('livraison.includes.detachPanierButton')
			</td>

		@empty

		<h4>Aucun panier n’est encore lié à cette livraison</h4>

		@endforelse
		</tr>
	</tbody>
</table>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalChoixPaniers">
	<i class="fa fa-btn fa-shopping-basket"></i>Gérer les paniers
</button>






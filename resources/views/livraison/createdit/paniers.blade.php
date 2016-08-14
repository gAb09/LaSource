	<h4 class="">Les paniers</h4>



	<table class="panierschoisis col-md-9">
		<tbody>
			@forelse($panierschoisis as $panier)

			<tr>

				<td style="width:15%">
					<!-- Edit -->
					<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ModalEditPanier">
						<i class="fa fa-btn fa-edit fa-lg"></i>
					</a>
					<!-- panier id -->
					Panier n° {{ $panier->id }}
					<input type="hidden" class="id" name="panier_id[]" value="{{ $panier->id or old('panier_id') }}">
				</td>

				<!-- type
				<td style="width:150px">
					{{ $panier->type }}
				</td>	 -->

				<!-- nom_court -->
				<td class="nomcourt" style="width:15%">
					{!! $panier->type !!} / {!! $panier->nom_court !!}
				</td>


				<!-- producteur -->
				<td class="form-group {{ $errors->has('producteur.'.$panier->id) ? ' has-error' : '' }}" style="width:58%">
					<!-- validation -->
					@if ($errors->has('producteur.'.$panier->id))
					<span class="help-block">
						<strong>{{ $errors->first('producteur.'.$panier->id) }}</strong>
					</span>
					@endif
					<!-- affichage -->
					<select name="producteur[{{ $panier->id }}]">
						@if($panier->prod_value == 0))
						<option value="0" selected="selected">producteur à déterminer</option>
						@endif
						@forelse($panier->producteur as $producteur)

						@if($panier->prod_value == $producteur->id)
						<option value="{!! $producteur->id !!}" selected="selected">{!! $producteur->nompourpaniers !!}</option>

						@else
						<option value="{!! $producteur->id !!}">{!! $producteur->nompourpaniers !!}</option>
						@endif

						@empty
						<option value="0" selected="selected">la liste des producteurs est vide</option>
						@endforelse

					</select>
					<div>
						<a class="btn btn-xs" onClick="javascript:listProducteursForPanier({{$panier->id}})" data-toggle="modal" data-target="#ModallistProducteursForPanier">
							<i class="fa fa-btn fa-edit"></i>
							Modifier les producteurs liés
						</a>
					</div>
				</td>

				<!-- prix livraison-->
				<td class="form-group {{ $errors->has('prix_livraison.'.$panier->id) ? ' has-error' : '' }}" style="width:40%">
					<!-- validation -->
					@if ($errors->has('prix_livraison.'.$panier->id))
					<span class="help-block">
						<strong>{{ $errors->first('prix_livraison.'.$panier->id) }}</strong>
					</span>
					@endif
					<!-- affichage -->
					Prix livraison &nbsp;
					<input type="text" class="prix prixlivraison" style="width:40px" name="prix_livraison[{{ $panier->id}}]" value="{{ $panier->liv_value }}">
				</td>

				<!-- prix commun-->
				<td style="width:15%">				
					Prix base &nbsp;
					<input type="text" class="prix"  name="prix_base[]" value="{{ $panier->prix_base or old('prix_base') }}" onClick="javascript:reporterPrixBase(this)">
				</td>
				<td style="width:15%">
					<button type="button" class="btn btn-warning btn-xs" onClick="javascript:document.location.href='{{ route('livraisonDetachPanier', ['livraison' => $model->id, 'panier' => $panier->id]) }}';">
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

		<button type="button" class="btn btn-primary btn-xs" onClick="javascript:listPaniers({{$model->id}})" data-toggle="modal" data-target="#ModallistPaniers">
			<i class="fa fa-btn fa-shopping-basket"></i> <br />Liste des paniers
		</button>

		<button type="submit" class="btn btn-success btn-xs">
			<i class="fa fa-btn fa-save"></i> <br />Valider ces paniers
		</button>

	</div>
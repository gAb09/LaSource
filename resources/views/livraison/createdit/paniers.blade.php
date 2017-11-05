	<h4 class="SsTitre">Les paniers</h4>



	<table class="paniers_lied col-md-9">
		<tbody>
			@forelse($model->Panier as $panier)

			<tr>
				<td style="width:15%">
					<!-- Edit -->
					<a class="btn btn-primary btn-xs"  href="{{ URL::route('panier.edit', $panier->id) }}">
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
					<?php
					if (isset(old('producteur')[$panier->id])) {
						$value_producteur = old('producteur')[$panier->id];
					}elseif (is_null($panier->pivot->producteur)) {
						$value_producteur = 0;
					}else{
						$value_producteur = $panier->pivot->producteur;
					}
					?>
				<td class="form-group {{ $errors->has('producteur.'.$panier->id) ? ' has-error' : '' }}" style="width:58%">
					<!-- validation -->
					@if ($errors->has('producteur.'.$panier->id))
					<span class="help-block">
						<strong>{{ $errors->first('producteur.'.$panier->id) }}</strong>
					</span>
					@endif
					<!-- affichage -->
					<select class="{{ $panier->changed}}" name="producteur[{{ $panier->id }}]" onChange="javascript:changementDatasPaniersDetected(this);">
						@if($value_producteur == 0))
						<option value="0" selected="selected">producteur à déterminer</option>
						@endif
						@forelse($panier->producteur as $producteur)

						@if($value_producteur == $producteur->id)
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
							Modifier la liste des producteurs
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
					<?php
					if (isset(old('prix_livraison')[$panier->id])) {
						$value_prix_livraison = old('prix_livraison')[$panier->id];
					}elseif (is_null($panier->pivot->prix_livraison)) {
						$value_prix_livraison = 0;
					}else{
						$value_prix_livraison = $panier->pivot->prix_livraison;
					}
					?>
					<input type="text" class="prix prixlivraison {{ $panier->changed}}" style="width:50px" name="prix_livraison[{{ $panier->id}}]" value="{{ $value_prix_livraison }}" onChange="javascript:changementDatasPaniersDetected(this);">
				</td>

				<!-- prix commun-->
				<td style="width:15%">				
					Prix base &nbsp;
					<input type="text" class="prix"  name="prix_base[]" value="{{ $panier->prix_base }}" onClick="javascript:reporterPrixBase(this)">
				</td>
				<td style="width:15%">
					<button type="button" class="btn btn-primary btn-xs" onClick="javascript:document.location.href='{{ route('livraisonDetachPanier', ['livraison' => $model->id, 'panier' => $panier->id]) }}';">
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
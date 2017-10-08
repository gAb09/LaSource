<div>
	<h4>Les dates</h4>
</div>

	<!-- date_livraison -->
@if ($errors->has('date_livraison'))
	<div id="div_date_livraison" class="datecontainer error_txt">
@else
	<div id="div_date_livraison" class="datecontainer">
@endif
		@include('livraison.partials.date_livraison')
	</div>


	<!-- date_paiement -->
@if ($errors->has('date_paiement'))
	<div id="div_date_paiement" class="datecontainer error_txt">
@else
	<div id="div_date_paiement" class="datecontainer">
@endif
		@include('livraison.partials.date_paiement')
	</div>


<!-- date_cloture -->
@if ($errors->has('date_cloture'))
	<div id="div_date_cloture" class="datecontainer error_txt">
@else
	<div id="div_date_cloture" class="datecontainer">
@endif
		@include('livraison.partials.date_cloture')
	</div>

<!-- statut (masqué) -->
@if($mode == 'edit')
<input type="hidden" id="statut" name="statut" value="{{ old('statut', $model->statut) }}">
@elseif($mode == 'create')
<input type="hidden" id="statut" name="statut" value="L_CREATED">
@endif
<div>
	<button type="submit" class="btn btn-sm btn-success">
		<i class="fa fa-btn fa-save fa-lg"></i>Valider ces dates
	</button>
</div>
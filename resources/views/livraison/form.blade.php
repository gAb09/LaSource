	<!-- Les dates -->
	<div class="col-md-12 flexcontainer livraison_dates">
		@include('livraison.form_dates')
	</div>

	<!-- Les paniers -->
	<div class="col-md-12 flexcontainer livraison_paniers">
		@include('livraison.form_paniers')
	</div>

	<button type="submit" class="btn btn-primary">
		<i class="fa fa-btn fa-envelope"></i>Préparer mail pour clients
	</button>

@section('modal')
@include('livraison.choixpaniers_modale')
@show

<div class="">
	<h4 class="col-md-12">Les paniers</h4><br />
	<button type="button" class="btn btn-success btn-xs">
		<i class="fa fa-btn fa-check"></i>Valider tous les paniers
	</button>
</div>

<div id="panierschoisis" class="panierschoisis col-md-8">
	@foreach($paniers as $panier)
	@if($panier->lied == 'lied')
	<div class="flexcontainer unpanierchoisi">

		<div>{{ $panier->type }}{{ $panier->lied }}</div>	

		<div>{!! $panier->nom_court !!}</div>

		<div>Producteur</div>

		<div class="champ">
			Prix
			<input type="text" name="prix_commun" value="{{ $panier->prix_commun or old('prix_commun') }}">
		</div>

		<button type="button" class="btn btn-success btn-xs">
			<i class="fa fa-btn fa-check"></i>Valider ce panier
		</button>

		<button type="button" class="btn btn-warning btn-xs">
			<i class="fa fa-btn fa-unlink"></i>Délier ce panier
		</button>

	</div>
	@endif
	@endforeach
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
	<i class="fa fa-btn fa-shopping-basket"></i>Lier de nouveaux paniers
</button>


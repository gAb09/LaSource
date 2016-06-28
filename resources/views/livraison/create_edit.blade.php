@extends('layouts.app')

@section('titre')
@parent
@stop


@section('message')
@parent
@include('livraison.errors')
@stop


@section('topcontent1')
@stop


@section('topcontent2')
<h4>Créer/modifier une livraison :</h4>
<ol>
<li>Assigner les 3 dates.</li>
<li>Appeler la liste des paniers pour en lier à cette livraison ou individuellement les délier.</li>
<li>Une fois un (plusieurs) panier(s) ajouté(s), pensez à vérifier le producteur et le prix associés.</li>
<li>Il est possible de valider indépendament les dates, un panier, tous les paniers ou l'ensemble de la page.</li>
</ol>
@stop


@section('content')

<div class="col-md-12">
	@section('create_edit')
	@show

	<button type="submit" class="btn btn-info">
		<i class="fa fa-btn fa-list-ul"></i>Retour à la liste
	</button>

	<button type="submit" class="btn btn-primary">
		<i class="fa fa-btn fa-envelope"></i>Préparer mail pour clients
	</button>

</div>

@stop
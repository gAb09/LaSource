@extends('layouts.app')

<?php
$expanded_livraisons = $datas['expanded_livraisons'];
$restricted_livraisons = $datas['restricted_livraisons'];
$indisponible = $datas['indisponible'];
?>

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage titresmaller">{{ $titre_page }}</h1>
@stop



@section('modemploi')
<p> Il n'est pas forcément opportun que l'application attache ou détache automatiquement un relais suite à une modification de ses disponibilités.<br />
	Notamment si la date de clôture d'une livraison est très proche (c'est pourquoi celle-ci est rappellée pour chaque livraison).<br />
</p>
<p>
	D'autre part, dans le cas d'une perte de disponibilité, il peut être préférable d'apporter une solution adaptée, (par exemple décaler les 3 dates d'une livraison)<br />
	Toutes les solutions n'étant pas envisageable, la possibilité est aussi offerte d'opter pour le traitement manuel d'une livraison.<br />
	Si vous choisissez cette option, le problème sera mémorisé et apparaîtra dans votre Tableau de bord.
</p>
<p>Si c'est une des options “ajout automatique” ou “detach automatique” qui est choisie, “{{$indisponible->nom}}” sera attaché à la livraison ou en sera détaché,<br />
	dnas les 2 cas, un mail sera préparé, à destination de tous les clients, qui pourront alors changer de relais, ou encore annuler ou créer une commande.<br />
</p>
@stop


@section('content')
<form class="handleLivraisonChanges form-inline col-md-10 col-md-offset-1" role="form" method="POST" action="{{ URL::route('indisponibilité.handleLivraisonChanges', $indisponible->id) }}">
	{!! csrf_field() !!}
	<input type="hidden" name="_method" value="PUT">

	<!-- livraisons restreintes -->
	@if(!is_null($restricted_livraisons))
		<h3>Livraisons qui se voient restreintes</h3>

		@foreach($restricted_livraisons as $livraison)
			<hr />
			<div class="livraison">
				<p>
					Livraison du {{ $livraison->date_livraison_enClair }}<br />
					<span>
						Clôture des commandes dans <strong>{{ $livraison->date_cloture_delai }} jours</strong> : {{ $livraison->date_cloture_enClair }}<br />
					</span>
				</p>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="nochange" checked>
						Laisser la livraison telle quelle
					</label>
				</div>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="detach">
						Détacher automatiquement “{{ $indisponible->nom }}” 
					</label>
				</div>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="reported">
						Mémoriser pour traitement manuel ultérieur
					</label>
				</div>
			</div>
		@endforeach
	@endif


<!-- livraisons étendues -->
	@if(!is_null($expanded_livraisons))
		<h3>Livraisons qui se voient étendues</h3>

		@foreach($expanded_livraisons as $livraison)
			<hr />
			<div class="livraison">
				<p>
					Livraison du {{ $livraison->date_livraison_enClair }}<br />
					<span>
						Clôture des commandes dans <strong>{{ $livraison->date_cloture_delai }} jours</strong> : {{ $livraison->date_cloture_enClair }}
					</span>
				</p>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="nochange" checked>
						Laisser la livraison telle quelle
					</label>
				</div>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="attach">
						Attacher automatiquement “{{ $indisponible->nom }}” 
					</label>
				</div>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="reported">
						Mémoriser pour traitement manuel ultérieur
					</label>
				</div>
			</div>
		@endforeach
	@endif

	<hr />
	<button type="submit" class="btn btn-success">Valider</button>
</form>
@stop


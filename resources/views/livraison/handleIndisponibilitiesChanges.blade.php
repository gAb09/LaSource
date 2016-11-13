@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage titresmaller">{{ ucfirst($titre_page) }}</h1>
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
<p>Si c'est une des options “ajout automatique” ou “detach automatique” qui est choisie, “{{$indisponisable->nom}}” sera attaché à la livraison ou en sera détaché,<br />
	dnas les 2 cas, un mail sera préparé, à destination de tous les clients, qui pourront alors changer de relais, ou encore annuler ou créer une commande.<br />
</p>
@stop


@section('content')
<form class="handleLivraisonChanges form-inline col-md-10 col-md-offset-1" role="form" method="POST" action="{{ URL::route('relais.handleIndisponibilitiesChanges', $indisponisable->id) }}">
	{!! csrf_field() !!}
	<input type="hidden" name="_method" value="PUT">

	<!-- livraisons restreintes -->
	@if(!$restricted_livraisons->isEmpty())
		<h3>Livraisons qui ne disposeraient plus de “{{$indisponisable->nom}}”</h3>

		@foreach($restricted_livraisons as $livraison)
			<hr />
			<div class="livraison">
				<p>
					Livraison du {{ $livraison->date_livraison_enClair }} {{ $livraison->id }}<br />
					<span>
						Pour info la clôture des commandes est fixée au {{ $livraison->date_cloture_enClair }}, donc dans <strong>{{ $livraison->date_cloture_delai }} jours</strong><br />
					</span>
				</p>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="nochange" checked>
						Laisser cette livraison telle quelle
					</label>
				</div>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="detach">
						Détacher automatiquement “{{ $indisponisable->nom }} de cette livraison”. Un mail prévenant les clients et les différents acteurs concernés sera automatiquement préparé.
					</label>
				</div>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="reported">
						Enregistrer les éléments en vue d’un traitement ultérieur de cette livraison. Ce traitement pourra être effectué depuis le tableau de bord.
					</label>
				</div>
			</div>
		@endforeach
	@endif


<!-- livraisons étendues -->
	@if(!$extended_livraisons->isEmpty())
		<h3>Livraisons qui pourraient disposer à nouveau de “{{$indisponisable->nom}}”</h3>

		@foreach($extended_livraisons as $livraison)
			<hr />
			<div class="livraison">
				<p>
					Livraison du {{ $livraison->date_livraison_enClair }}  ({{ $livraison->id }})<br />
					<span>
						Pour info la clôture des commandes est fixée au {{ $livraison->date_cloture_enClair }}, donc dans <strong>{{ $livraison->date_cloture_delai }} jours</strong><br />
					</span>
				</p>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="nochange" checked>
						Laisser cette livraison telle quelle.
					</label>
				</div>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="attach">
						Associer à nouveau “{{ $indisponisable->nom }}” à cette livraison. Un mail prévenant les clients et les différents acteurs concernés sera automatiquement préparé.
					</label>
				</div>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="reported">
						Enregistrer les éléments en vue d’un traitement ultérieur de cette livraison. Ce traitement pourra être effectué depuis le tableau de bord.
					</label>
				</div>
			</div>
		@endforeach
	@endif

	<hr />
	<button type="submit" class="btn btn-success">Valider</button>
	<a href="{{ route('annulationIndisponibilityChanges') }}" class="btn btn-danger">Annuler {{$action_for_view}}</a>
</form>
@stop


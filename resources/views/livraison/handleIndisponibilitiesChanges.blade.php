@extends('layouts.app')

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
<form class="handleLivraisonChanges form-inline col-md-10 col-md-offset-1" role="form" method="POST" action="{{ URL::route('livraison.handleIndisponibilitiesChanges', $indisponible->id) }}">
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
	@if(!is_null($extended_livraisons))
		<h3>Livraisons qui pourraient disposer à nouveau de “{{$indisponible->nom}}”</h3>

		@foreach($extended_livraisons as $livraison)
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
						Laisser la livraison telle quelle.
					</label>
				</div>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="attach">
						Associer à nouveau “{{ $indisponible->nom }}”. Un mail sera automatiquement préparé.
					</label>
				</div>
				<div class="radio" style="display:inherit;">
					<label>
						<input type="radio" name="livraison_id[{{ $livraison->id }}]" value="reported">
						Enregistrer les éléments en vue d’un traitement ultérieur de cette livraison.
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


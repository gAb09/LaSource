@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ $titre_page }}</h1>
@stop



@section('modemploi')
<p>
	Sur VALIDER :<br />
	• Chaque <strong>livraison cochée</strong> ci-dessous disposera à nouveau du relais “{{$relais->nom}}” pour le retrait de panier.<br />
	Un mail sera automatiquement envoyé à tous les clients qui pourront alors changer de relais ou passer une commande.<br />
	•Si <strong>aucune n'est cochée</strong>, rien ne sera changé aux livraisons, l'indisponibilité sera simplement supprimée.<br /><br />
	Sur ANNULER :<br />
	• La suppression de l'indisponibilité sera annulée.
</p>
@stop


@section('content')
<form class="relais_redispo form-inline col-md-10 col-md-offset-1" role="form" method="POST" action="{{ URL::route('relais.reattach', $relais->id) }}">
	{!! csrf_field() !!}
	<input type="hidden" name="_method" value="PUT">

	@foreach($livraisons as $livraison)

	<div>
		<input type="checkbox" class="form-control" name="livraison_id[]" value="{{ $livraison->id }}">
		<span>
			&nbsp;Livraison du {{ $livraison->date_livraison }}<br />
		</span>
		Cloture des commandes dans <strong>{{ $livraison->date_cloture_delai }} jours</strong> : {{ $livraison->date_cloture }}<hr />
	</div>
	@endforeach
	<button type="submit" class="btn btn-success">Valider</button>
	<button name="Annuler" class="btn btn-danger">Annuler</button>
</form>
@stop

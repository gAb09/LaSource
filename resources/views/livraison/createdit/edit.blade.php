@extends('livraison.createdit.main')

@section('titre')
@parent
@stop


@section('message')
@parent
@stop


@section('topcontent1')
<h1 class="titrepage">{!! trans('titrepage.livraison.edit', ['date_titrepage' => $date_titrepage]) !!} <small>({{ trans('constante.'.$model->statut) }})</small></h1>
@parent
@stop



@section('createdit')
	@if($model->statut == 'L_ARCHIVED')
	@include('livraison.show_archived')

	@else
	<!-- Les dates -->
	<form class="form-inline" role="form" method="POST" action="{{ route('livraison.update', $model->id) }}">
		{!! csrf_field() !!}
		<input type="hidden" class="form-control" name="_method" value="PUT">

		<div class="col-md-12 flexcontainer edit_show_livraison form_dates">
			@include('livraison.createdit.dates', ['mode' => 'edit'])
		</div>
	</form>

	<!-- Les paniers -->
	<form class="form-inline" role="form" method="POST" action="{{ route('livraisonSyncPaniers', [$model->id]) }}" onSubmit="javascript:resetChangeDetected();">
		{!! csrf_field() !!}

		<div class="col-md-12 flexcontainer edit_show_livraison form_paniers">
			@include('livraison.createdit.paniers')
		</div>
	</form>

	<!-- Les relais -->
	<form name="relaisForm" class="form-inline" role="form" method="POST" action="{{ route('livraisonSyncRelaiss', [$model->id]) }}">
		{!! csrf_field() !!}
		<input type="hidden" class="form-control" name="_method" value="PUT">

		<div class="col-md-12 flexcontainer edit_show_livraison form_relaiss">
			@include('livraison.createdit.relais')
		</div>
	</form>

	<!-- Les modes de paiement -->
	<form name="paiementForm" class="form-inline" role="form" method="POST" action="{{ route('livraisonSyncModespaiements', [$model->id]) }}">
		{!! csrf_field() !!}
		<input type="hidden" class="form-control" name="_method" value="PUT">

		<div class="col-md-12 flexcontainer edit_show_livraison form_modepaiements">
			@include('livraison.createdit.modepaiements')
		</div>
	</form>
@endif

@stop
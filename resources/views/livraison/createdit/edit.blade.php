@extends('livraison.createdit.main')

@section('titre')
@parent
@stop


@section('message')
@parent
@stop


@section('topcontent1')
<h1 class="titrepage">{!! trans('titrepage.livraison.edit', ['date_titrepage' => $date_titrepage]) !!}</h1>
@parent
@stop



@section('createdit')

<!-- Les dates -->
<form class="form-inline" role="form" method="POST" action="{{ route('livraison.update', $model->id) }}">
	{!! csrf_field() !!}
	<input type="hidden" class="form-control" name="_method" value="PUT">

	<div class="col-md-12 flexcontainer form_dates">
		@include('livraison.createdit.dates')
	</div>
</form>

<!-- Les paniers -->
<form class="form-inline" role="form" method="POST" action="{{ route('livraisonSyncPaniers', [$model->id]) }}">
	{!! csrf_field() !!}

	<div class="col-md-12 flexcontainer form_paniers">
		@include('livraison.createdit.paniers')
	</div>
</form>

<!-- Les relais -->
<form name="relaisForm" class="form-inline" role="form" method="POST" action="{{ route('livraisonSyncRelaiss', [$model->id]) }}">
	{!! csrf_field() !!}
	<input type="hidden" class="form-control" name="_method" value="PUT">

	<div class="col-md-12 flexcontainer form_relaiss">
		@include('livraison.createdit.relais')
	</div>
</form>


@stop
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


@section('topcontent2')
@parent
@stop


@section('createdit')

<!-- Les dates -->
<form class="form-inline" role="form" method="POST" action="{{ route('livraison.update', $item->id) }}">
	{!! csrf_field() !!}
	<input type="hidden" class="form-control" name="_method" value="PUT">

	<div class="col-md-12 flexcontainer form_dates">
		@include('livraison.createdit.self')
	</div>
</form>

<!-- Les paniers -->
<form class="form-inline" role="form" method="POST" action="{{ route('livraisonSyncPaniers', [$item->id]) }}">
	{!! csrf_field() !!}

	<div class="col-md-12 flexcontainer form_paniers">
		@include('livraison.createdit.paniers')
	</div>
</form>

@stop
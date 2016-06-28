@extends('livraison.create_edit')

@section('titre')
@parent
@stop


@section('message')
@parent
@include('livraison.errors')
@stop


@section('topcontent1')
<h1 class="titrepage">{!! trans('titrepage.livraison.edit', ['date_titrepage' => $date_titrepage]) !!}</h1>
@stop


@section('topcontent2')
@parent
@stop


@section('create_edit')

<form class="form-inline" role="form" method="POST" action="{{ route('livraison.update', $item->id) }}">
	{!! csrf_field() !!}
	<input type="hidden" class="form-control" name="_method" value="PUT">

	<!-- Les dates -->
	<div class="col-md-12 flexcontainer livraison_dates">
		@include('livraison.form_dates')
	</div>

	<!-- Les paniers -->
	<div class="col-md-12 flexcontainer livraison_paniers">
		@include('livraison.form_paniers')
	</div>

	<div class="col-md-12 flexcontainer livraison_dates">
		<button type="submit" class="btn  btn-success">
			<i class="fa fa-btn fa-save"></i>Validation globale
		</button>
	</div>


</form>

@stop
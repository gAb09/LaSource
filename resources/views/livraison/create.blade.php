@extends('livraison.handle')

@section('titre')
@parent
@stop


@section('message')
@parent
@stop


@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.livraison.create') }}</h1>
@stop


@section('topcontent2')
@parent
@stop


@section('createOrEdit')

<form class="form-inline" role="form" method="POST" action="{{ route('livraison.store') }}">
	{!! csrf_field() !!}
	
	<!-- Les dates -->
	<div class="col-md-12 flexcontainer form_dates">
		@include('livraison.form_dates')
	</div>

	@stop
@extends('layouts.app')

@section('titre')
@parent
@stop


@section('message')
@parent
@include('livraison.errors')
@stop


@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.livraison.create') }}</h1>
@stop


@section('topcontent2')
@include('livraison.modemploi')
@stop


@section('content')

<div class="col-md-12">

	<form class="form-inline" role="form" method="POST" action="{{ route('livraison.store') }}">
		{!! csrf_field() !!}

		@include('livraison.form')

		<button type="submit" class="btn btn-success">
			<i class="fa fa-btn fa-check"></i>Store globalement
		</button>


	</form>

</div>

@stop
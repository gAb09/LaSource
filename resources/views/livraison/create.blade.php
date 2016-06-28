@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.livraison.create') }}</h1>
@stop


@section('topcontent2')
@stop


@section('content')

<div class="col-md-12">

	<form class="form-inline" role="form" method="POST" action="{{ route('livraison.store') }}">
		{!! csrf_field() !!}
		<!-- Les dates -->
		<div class="col-md-12 flexcontainer" style="background-color:#EEE">
			@include('livraison.dates_form')
		</div>
		
		<!-- Les paniers -->
		<div class="col-md-12" style="background-color:#EEE;margin-top:10px">
			@include('livraison.paniers_form')
		</div>
		
		<button type="submit" class="btn btn-success">
			<i class="fa fa-btn fa-user"></i>Valider globalement
		</button>

		<button type="submit" class="btn btn-primary">
			<i class="fa fa-btn fa-user"></i>Préparer mail aux clients
		</button>

	</form>

</div>

@stop
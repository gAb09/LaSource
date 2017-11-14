@extends('livraison.createdit.main')

@section('titre')
@parent
@endsection


@section('message')
@parent
@endsection


@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.livraison.create') }}</h1>
@include('livraison.partials.param_ecarts')
@parent
@endsection



@section('createdit')

<form class="form-inline" role="form" method="POST" action="{{ route('livraison.store') }}">
	{!! csrf_field() !!}
	
	<!-- Les dates -->
	<div class="col-md-12 flexcontainer edit_show_livraison form_dates">
		@include('livraison.createdit.dates', ['mode' => 'create'])
	</div>
</form>

	@endsection
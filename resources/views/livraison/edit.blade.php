@extends('layouts.app')

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
@include('livraison.modemploi')
@stop


@section('content')

<div class="col-md-12">

	<form class="form-inline" role="form" method="POST" action="{{ route('livraison.update', $item->id) }}">
		{!! csrf_field() !!}
		<input type="hidden" class="form-control" name="_method" value="PUT">

		@include('livraison.form')

		<button type="submit" class="btn  btn-success">
			<i class="fa fa-btn fa-save"></i>Update global
		</button>


	</form>

</div>

@stop
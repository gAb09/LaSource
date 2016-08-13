@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.producteur.trashed') }}</h1>
@stop


@section('modemploi')
<p>
Un <strong>double-clic</strong> sur un producteur le sortira de la corbeille et permettra sa modification.
</p>
@stop


@section('content')
	@include('producteur.indexcontent')
@stop

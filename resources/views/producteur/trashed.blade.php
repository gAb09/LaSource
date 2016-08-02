@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.producteur.trashed') }}</h1>
@stop


@section('topcontent2')
<p class ="modemploi">
Un <strong>double-clic</strong> sur un producteur le sortira de la corbeille et permettra sa modification.
</p>
@stop


@section('content')
<div id="producteurs_trashed" class="offset3 span11 flexcontainer">
	@include('producteur.indexcontent')
</div>
@stop

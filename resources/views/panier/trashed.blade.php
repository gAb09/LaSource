@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.panier.trashed') }}</h1>
@stop


@section('topcontent2')
<p class ="modemploi">
Un <strong>double-clic</strong> sur un panier le sortira de la corbeille et permettra sa modification.
</p>
@stop


@section('content')
<div id="paniers_trashed" class="offset3 span11 flexcontainer">
	@include('panier.indexcontent')
</div>
@stop

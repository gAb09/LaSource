@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.modepaiement.trashed') }}</h1>
@stop


@section('topcontent2')
<p class ="modemploi">
Un <strong>double-clic</strong> sur un modepaiement le sortira de la corbeille et permettra sa modification.
</p>
@stop


@section('content')
	@include('modepaiement.indexcontent')
@stop

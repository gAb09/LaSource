@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.panier.trashed') }}</h1>
@stop


@section('topcontent2')
<p class ="moddemploi">
Un <strong>double-clic</strong> sur un panier le sortira de la corbeille et permettra sa modification.
</p>
@stop


@section('content')
@include('panier.indexitem')
@stop
@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.panier.index') }}</h1>
@stop


@section('topcontent2')
<a href="{{ route('panier.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Ajouter un panier</a>
@stop


@section('content')
@include('panier.indexcontainer')
@stop


@section('script')
@parent
<script src="/js/panier.js"></script>
@stop
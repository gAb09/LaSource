@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.panier.index') }}</h1>

<a href="{{ route('panier.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Créer un panier</a>
@stop


@section('content')
	@include('panier.indexcontent')
@stop


@section('script')
@parent
<script src="/js/panier.js"></script>
@stop
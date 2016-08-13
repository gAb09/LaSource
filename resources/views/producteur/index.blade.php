@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.producteur.index') }}</h1>

<a href="{{ route('producteur.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Créer un producteur</a>
@stop


@section('content')
	@include('producteur.indexcontent')
@stop


@section('script')
@parent
<script src="/js/producteur.js"></script>
@stop

@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.relais.index') }}</h1>
@stop


@section('topcontent2')
<a href="{{ route('relais.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Créer un relais</a>
@stop


@section('content')
	@include('relais.indexcontent')
@stop


@section('script')
@parent
<script src="/js/relais.js"></script>
@stop

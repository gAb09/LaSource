@extends('layouts.app')

@section('titre')
Livraisons en cours
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.livraison.enCours') }}</h1>
@stop


@section('message')
@parent
@stop


@section('content')
@include('livraison.partials.enCours', ['livraisons' => 'livraisons'])
@stop

@section('script')
@parent
<script src="/js/livraison.js"></script>
@stop

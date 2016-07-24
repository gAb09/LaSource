@extends('layouts.app')

@section('titre')
Tableau de bord
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.dashboard.main') }}</h1>
@stop


@section('topcontent2')
@stop



@section('message')
@parent
@stop


@section('content')
DASHBOARD A VENIR
@include('livraison.partials.enCours', ['livraisons' => $livraisons])
@stop

@section('script')
@parent
<script src="/js/livraison.js"></script>
@stop

@extends('layouts.app')

@section('titre')
Livraisons en cours
@parent
@endsection



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.livraison.enCours') }}</h1>
@endsection


@section('message')
@parent
@endsection


@section('content')
@include('livraison.partials.enCours', ['livraisons' => 'livraisons'])
@endsection

@section('script')
@parent
<script src="/js/livraison.js"></script>
@endsection

@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.modepaiement.index') }}</h1>

<a href="{{ route('modepaiement.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Créer un mode de paiement</a>
@stop


@section('content')
	@include('modepaiement.indexcontent')
@stop


@section('script')
@parent
<script src="/js/modepaiement.js"></script>
@stop
@extends('layouts.app')

@section('titre')
Tableau de bord
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.dashboard.main') }}</h1>
@stop


@section('message')
@parent
@stop


@section('content')
DASHBOARD A VENIR
<div id="dashboard_main" class="offset3 span11 flexcontainer">

	@include('dashboard.partials.base')


	<a class="btn btn-primary" onClick="javascript:getComposerMailContent()">
		<i class="fa fa-btn fa-envelope"></i>
		Gérer les mails pour cette livraison
	</a>

	<!-- MAILS -->
    <div id="composer_mails" class="container-fluid">
    	Ici
    </div>
</div>


@include('livraison.partials.enCours', ['livraisons' => $livraisons])
@stop

@section('script')
@parent
<script src="/js/dashboard.js"></script>
@stop

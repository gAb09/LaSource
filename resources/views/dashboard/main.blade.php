@extends('layouts.app')

@section('titre')
Tableau de bord
@parent
@endsection



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.dashboard.main') }}</h1>
@endsection


@section('message')
@parent
@endsection


@section('content')
DASHBOARD A VENIR
<div id="dashboard_main" class="offset3 span11 flexcontainer">

	@include('dashboard.partials.livraisons')
	@include('dashboard.partials.commandes')
	@include('dashboard.partials.relais')
	@include('dashboard.partials.producteurs')


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
@endsection

@section('script')
@parent
<script src="/js/dashboard.js"></script>
@endsection

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
<div class="container-fluid">
		<div id="dashboard_console" class="col-md-2 flexcontainer">

			{{-- @include('dashboard.console.livraisons')
			@include('dashboard.console.commandes')
			@include('dashboard.console.relais')
			@include('dashboard.console.producteurs')
			@include('dashboard.console.mails')
			@include('dashboard.console.indispos') --}}

		</div>

		<div id="dashboard_content" class="col-md-10">
			@if(isset($message))
				{{$message}}
			@else

				@foreach($collections as $collection)
				<div model="livraison" class="livraison">
					@include('dashboard.rapports.livraison', ['livraison' => $collection])
				</div>
				<div model="commande" class="commande">
					@include('dashboard.rapports.commande', ['commandes' => $collection->rapport_commandes])
				</div>
				<div model="producteur" class="producteur">
					@include('dashboard.rapports.producteur', ['producteurs' => $collection->rapport_producteurs])
				</div>
				<div model="relai" class="relai">
					@include('dashboard.rapports.relai', ['relais' => $collection->rapport_relais])
				</div>
				@endforeach

				<div model="mails" class="mails">
				@include('dashboard.rapports.mails')

				<div model="indispos" class="indispos">
				@include('dashboard.rapports.indispos')

			@endif

		</div>
</div>
@endsection

@section('script')
@parent
<script src="/js/dashboard.js"></script>
@endsection

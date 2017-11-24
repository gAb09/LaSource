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
<div class="container-fluid" style="background-color:grey">
		<div id="dashboard_console" class="col-md-2 flexcontainer">

			@include('dashboard.console.livraisons')
			@include('dashboard.console.commandes')
			@include('dashboard.console.producteurs')
			@include('dashboard.console.relais')
			@include('dashboard.console.mails')
			@include('dashboard.console.indispos')

		</div>

		<div id="dashboard_content" class="col-md-10">
			@if(isset($message))
				<h3>{{$message}}</h3>
			@else

				@foreach($livraisons as $livraison)
				<div role="rapport" id="{{$livraison->id}}">
					<div role="livraison" class="livraison">
						@include('dashboard.rapports.livraison', ['livraison' => $livraison])
					</div>
					@if(!$livraison->rapport_commandes->isEmpty())
						<div role="commande" class="">
							@include('dashboard.rapports.commande', ['commandes' => $livraison->rapport_commandes])
						</div>
						<div role="producteur" class="hidden">
							@include('dashboard.rapports.producteur', ['producteurs' => $livraison->rapport_producteurs])
						</div>
						<div role="relai" class="hidden">
							@include('dashboard.rapports.relai', ['relais' => $livraison->rapport_relais])
						</div>
					@else
						<h3>À ce jour aucune commande n’a été passée pour cette livraison …</h3>
					@endif
				</div>
					@endforeach
				<div role="mail" class="mail hidden">
				@include('dashboard.rapports.mails')
				</div>

				<div role="indispo" class="indispo hidden">
				@include('dashboard.rapports.indispos')
				</div>

			@endif

		</div>
</div>
@endsection

@section('script')
@parent
<script src="/js/dashboard.js"></script>
@endsection

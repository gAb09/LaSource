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

			@include('dashboard.console.livraisons')
			{{-- @include('dashboard.console.commandes')
			@include('dashboard.console.relais')
			@include('dashboard.console.producteurs')
			@include('dashboard.console.mails')
			@include('dashboard.console.indispos') --}}

		</div>

		<div id="dashboard_content" class="col-md-10">
			@if(isset($message))
				{{$message}}
			@else

				@foreach($livraisons as $livraison)
				<div id="{{$livraison->id}}">
					<div model="livraison" class="livraison">
						@include('dashboard.rapports.livraison', ['livraison' => $livraison])
					</div>
					@if(!$livraison->rapport_commandes->isEmpty())
						<div model="commande" class="">
							@include('dashboard.rapports.commande', ['commandes' => $livraison->rapport_commandes])
						</div>
						<div model="producteur" class="">
							@include('dashboard.rapports.producteur', ['producteurs' => $livraison->rapport_producteurs])
						</div>
						<div model="relai" class="">
							@include('dashboard.rapports.relai', ['relais' => $livraison->rapport_relais])
						</div>
					@else
						<h3>À ce jour aucune commande n’a été passée pour cette livraison …</h3>
					@endif
				</div>
					@endforeach
				<div model="mails" class="mails">
				@include('dashboard.rapports.mails')
				</div>

				<div model="indispos" class="indispos">
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

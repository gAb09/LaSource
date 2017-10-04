@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.commande.index') }}</h1>

@stop



@section('message')
@parent
@stop


@section('content')
<table class="index_commandes  col-md-12">
	<thead>
		<th style="width:10%">
			N°
		</th>
		<th  style="width:15%">
			Client
		</th>
		<th  style="width:30%">
			Paniers commandés
		</th>
		<th  style="width:15%">
			Livraison concernée
		</th>
		<th style="width:10%">
			Paiement
		</th>
		<th style="width:25%">
			Relais
		</th>
		<th style="width:10%">
			Statut
		</th>
	</thead>

	<tbody>

		@foreach($models as $model)

		@include('commande.index_row')

		@endforeach

	</tbody>

</table>

{{ $models->links() }}

@stop

@section('script')
@parent
<!-- <script src="/js/livraison.js"></script> -->
@stop

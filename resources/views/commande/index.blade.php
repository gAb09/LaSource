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
<table class="index_livraisons  col-md-12">
	<thead>
		<th style="width:10%">
			N°
		</th>
		<th  style="width:20%">
			Client
		</th>
		<th  style="width:60%">
			Paniers commandés
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


@stop

@section('script')
@parent
<!-- <script src="/js/livraison.js"></script> -->
@stop

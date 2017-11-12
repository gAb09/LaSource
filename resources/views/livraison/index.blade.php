@extends('layouts.app')

@section('titre')
@parent
@endsection



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.livraison.index') }}</h1>

<a href="{{ route('livraison.create') }}" class="btn btn-primary"> <i class="fa fa-btn fa-trash-o"></i>
	Créer une livraison
</a>
@endsection



@section('message')
@parent
@endsection


@section('content')
<table class="index_livraisons  col-md-12">
	<thead>
		<th style="width:50px">
			N°
		</th>
		<th>
			Date de livraison
		</th>
		<th>
			Date limite de paiement
		</th>
		<th>
			Date de clôture des commandes
		</th>
		<th>
			Statut
		</th>
	</thead>

	<tbody>

		@foreach($models as $model)

		@include('livraison.index_row')

		@endforeach

	</tbody>

</table>

{!! $models->render() !!}


@endsection

@section('script')
@parent
<script src="/js/livraison.js"></script>
@endsection

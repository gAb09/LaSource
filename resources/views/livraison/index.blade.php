@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.livraison.index') }}</h1>
@stop


@section('topcontent2')
<a href="{{ route('livraison.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Ajouter une livraison</a>
@stop


@section('content')

<div class="offset3 span11 flexcontainer">

	<table class="livraisons">
		<caption> caption
		</caption>

		<thead>
			<th>
				Id
			</th>
			<th>
				Date de livraison
			</th>
			<th>
				Date de clôture des commandes
			</th>
			<th>
				Date limte de paiement
			</th>
		</thead>


		<tbody>

			@foreach($items as $item)

			@include('livraison.index_row')

			@endforeach

		</tbody>

	</table>

</div>

@stop

    @section('script')
    @parent
    <script src="/js/livraison.js"></script>
    @stop

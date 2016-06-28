@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.livraison.index') }}</h1>
@stop


@section('topcontent2')
<a href="{{ route('livraison.create') }}" 
class="btn btn-primary"
> 
<i class="fa fa-btn fa-trash-o"></i>Ajouter une livraison
</a>
@stop
            


@section('message')
@parent
@include('livraison.errors')
@stop


@section('content')
	<div class="flexcontainer ligne_livraison">

		<div>
			Id
		</div>
		<div>
			Date de clôture des commandes
		</div>
		<div>
			Date limite de paiement
		</div>
		<div>
			Date de livraison
		</div>
		<div>
			
		</div>
	</div>


<div id="tablebody">

	@foreach($items as $item)

	@include('livraison.index_row')

	@endforeach


</div>


@stop

@section('script')
@parent
<script src="/js/livraison.js"></script>
@stop

@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.livraison.index') }}</h1>
@stop


@section('topcontent2')
<button href="" 
class="btn-xs btn-primary"
onclick="javascript:createLivraison();"
> 
<i class="fa fa-btn fa-trash-o"></i>Ajouter une livraison
</button>
@stop
            


@section('message')
@parent
    @if ($errors->has('date_cloture'))
    <div class="alert alert-danger">
        {{ $errors->first('date_cloture') }}
    </div>
    @endif

    @if ($errors->has('date_paiement'))
    <div class="alert alert-danger">
        {{ $errors->first('date_paiement') }}
    </div>
    @endif


    @if ($errors->has('date_livraison'))
    <div class="alert alert-danger">
        {{ $errors->first('date_livraison') }}
    </div>
    @endif


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
			bouton
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

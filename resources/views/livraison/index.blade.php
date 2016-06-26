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


@section('content')
    @if ($errors->has('date_cloture'))
    <span class="help-block">
        <strong>{{ $errors->first('date_cloture') }}</strong>
    </span>
    @endif

    @if ($errors->has('date_paiement'))
    <span class="help-block">
        <strong>{{ $errors->first('date_paiement') }}</strong>
    </span>
    @endif


    @if ($errors->has('date_livraison'))
    <span class="help-block">
        <strong>{{ $errors->first('date_livraison') }}</strong>
    </span>
    @endif

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

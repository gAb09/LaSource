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

<div class="offset3 span11 flexcontainer">

	<table class="livraisons">
		<caption> caption
		</caption>

		<thead>
			<th>
				Id
			</th>
			<th>
				Date de clôture des commandes
			</th>
			<th>
				Date limite de paiement
			</th>
			<th>
				Date de livraison
			</th>
			<th>
				bouton
			</th>
		</thead>


		<tbody id="livraisons" >

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

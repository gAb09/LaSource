@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.panier.index') }}</h1>
@stop


@section('topcontent2')
<a href="{{ route('panier.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Ajouter un panier</a>
@stop


@section('content')

<div id="paniers_index" class="offset3 span11 flexcontainer">

	@foreach($items as $item)

	<div class="portrait {{$item->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/panier/{{ $item->id }}/edit';">

		<p class="blanccalque66">{{ $item->type }}</p>
		<p  class="blanccalque75"><strong>{!! $item->nom_court !!}</strong></p>
		{{ $item->prix_commun }}
		<p class="blanccalque50">{!! $item->nom !!}</p>
		<p class="blanccalque50" style="font-style:italic">{!! $item->idee !!}</p>
		<p>{{ $item->remarques }}</p>

	</div>

	@endforeach

</div>

@stop
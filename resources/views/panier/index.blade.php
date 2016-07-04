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

<div class="offset3 span11 flexcontainer">

	@foreach($items as $item)

		<div class="portrait {{$item->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/panier/{{ $item->id }}/edit';">

			<p class="encadred2">
				{!! $item->nom !!}<br />
				{!! $item->nom_court !!}<br />
			</p>
				{{ $item->famille }} / {{ $item->type }}<br />
				{{ $item->idee }}<br />
				{{ $item->prix_commun }}<br />
				<p>{{ $item->remarques }}</p>


		</div>

	@endforeach

</div>

@stop
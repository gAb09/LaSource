@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.modepaiement.index') }}</h1>
@stop


@section('topcontent2')
<a href="{{ route('modepaiement.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Ajouter un mode de paiement</a>
@stop


@section('content')

<div class="offset3 span11 flexcontainer">

	@foreach($items as $item)

	<div class="portrait {{$item->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/modepaiement/{{ $item->id }}/edit';">

		<p class="blanccalque33">
			{{ $item->nom }}<br />
		</p>
		<p>{{ $item->remarques }}</p>


	</div>

	@endforeach

</div>

@stop
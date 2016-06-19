@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.producteur.index') }}</h1>
@stop


@section('topcontent2')
	<a href="{{ route('producteur.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Ajouter un producteur</a>
@stop


@section('content')

<div class="offset3 span11 flexcontainer">

	@foreach($items as $item)

		<div class="portrait {{$item->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/producteur/{{ $item->id }}/edit';">

			<p class="encadred2">
				{{ $item->exploitation }}<br />
				{{ $item->prenom }} {{ $item->nom }}<br />
				{{ $item->paniers }}
			</p>
				{{ $item->tel }}<br />
				{{ $item->mobile }}<br />
				{{ $item->ad1 }}<br />
				@if($item->ad2)
				{{ $item->ad2 }}
				@endif
				{{ $item->cp }} {{ $item->ville }}<br />
				{{ $item->email }}
				<p>{{ $item->remarques }}</p>


		</div>

	@endforeach

</div>

@stop
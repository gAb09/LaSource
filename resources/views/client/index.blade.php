@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.client.index') }}</h1>
@stop


@section('topcontent2')
@stop


@section('content')

<div class="offset3 span11 flexcontainer">

	@foreach($items as $item)

		<div class="portrait {{$item->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/client/{{ $item->id }}/edit';">

			<p class="lighten50">
				{{ $item->prenom }} {{ $item->nom }}<br />
			</p>
				{{ $item->tel }}<br />
				{{ $item->mobile }}<br />
				{{ $item->ad1 }}<br />
				@if($item->ad2)
				{{ $item->ad2 }}
				@endif
				{{ $item->cp }} {{ $item->ville }}<br />
				{{ $item->user->email }}


		</div>

	@endforeach

</div>

@stop
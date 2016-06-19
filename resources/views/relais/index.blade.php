@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{trans('titrepage.relais.index')}}</h1>
@stop


@section('topcontent2')
	<a href="{{ route('relais.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Ajouter un relais</a>
@stop



@section('content')

<div class="offset3 span11 flexcontainer">

	@foreach($items as $item)

		<div class="portrait  {{$item->class_actif}}" ondblClick = "javascript:document.location.href='{{ route('relais.edit', $item->id) }}';">

			<p class="encadred2">
				{{ $item->ville }} {{ $item->tel }}<br />
				{{ $item->retrait }}
			</p>
				{{ $item->nom }}<br />
				{{ $item->ad1 }}<br />
				@if($item->ad2)
				{{ $item->ad2 }}<br />
				@endif
				{{ $item->cp }} {{ $item->ville }}<br />
				{{ $item->email }}
				<p>{{ $item->ouvertures }}</p>
				<p>{{ $item->remarques }}</p>


		</div>

	@endforeach
</div>

@stop
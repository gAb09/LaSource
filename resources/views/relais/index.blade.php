@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{$titre_page}}</h1>
@stop


@section('topcontent2')
@stop


@section('content')

<div class="offset3 span11 flexcontainer">

	@foreach($relaiss as $relais)

		<div class="portrait" ondblClick = "javascript:document.location.href='http://lasource/relais/{{ $relais->id }}/edit';">

			<p class="encadred2">
				{{ $relais->ville }} {{ $relais->tel }}<br />
				{{ $relais->retrait }}
			</p>
				{{ $relais->nom }}<br />
				{{ $relais->ad1 }}<br />
				@if($relais->ad2)
				{{ $relais->ad2 }}<br />
				@endif
				{{ $relais->cp }} {{ $relais->ville }}<br />
				{{ $relais->email }}
				<p>{{ $relais->ouvertures }}</p>
				<p>{{ $relais->remarques }}</p>


		</div>

	@endforeach
</div>

@stop
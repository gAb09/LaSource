@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{trans('titrepage.relais.index')}}</h1>
@stop


@section('topcontent2')
	<a href="{{ route('relais.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Créer un relais</a>
@stop



@section('content')

<div class="offset3 span11 flexcontainer">

	@foreach($models as $model)

		<div class="fiche  {{$model->class_actif}}" ondblClick = "javascript:document.location.href='{{ route('relais.edit', $model->id) }}';">

			<p class="lighten33">
				{{ $model->ville }} {{ $model->tel }}<br />
				{{ $model->retrait }}
			</p>
				{{ $model->nom }}<br />
				{{ $model->ad1 }}<br />
				@if($model->ad2)
				{{ $model->ad2 }}<br />
				@endif
				{{ $model->cp }} {{ $model->ville }}<br />
				{{ $model->email }}
				<p>{{ $model->ouvertures }}</p>
				<p>{{ $model->remarques }}</p>


		</div>

	@endforeach
</div>

@stop
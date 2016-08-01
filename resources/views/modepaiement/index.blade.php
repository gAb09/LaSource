@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.modepaiement.index') }}</h1>
@stop


@section('topcontent2')
<a href="{{ route('modepaiement.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Créer un mode de paiement</a>
@stop


@section('content')

<div class="offset3 span11 flexcontainer">

	@foreach($models as $model)

	<div class="portrait {{$model->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/modepaiement/{{ $model->id }}/edit';">

		<p class="lighten33">
			{{ $model->nom }}<br />
		</p>
		<p>{{ $model->remarques }}</p>


	</div>

	@endforeach

</div>

@stop
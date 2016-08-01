@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.producteur.index') }}</h1>
@stop


@section('topcontent2')
	<a href="{{ route('producteur.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Créer un producteur</a>
@stop


@section('content')

<div class="offset3 span11 flexcontainer">

	@foreach($models as $model)

		<div class="fiche {{$model->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/producteur/{{ $model->id }}/edit';">

			<p class="lighten33">
				{{ $model->exploitation }}<br />
				{{ $model->prenom }} {{ $model->nom }}<br />
				{{ $model->paniers }}
			</p>
				{{ $model->tel }}<br />
				{{ $model->mobile }}<br />
				{{ $model->ad1 }}<br />
				@if($model->ad2)
				{{ $model->ad2 }}
				@endif
				{{ $model->cp }} {{ $model->ville }}<br />
				{{ $model->email }}
				<p>{{ $model->remarques }}</p>


		</div>

	@endforeach

</div>

@stop
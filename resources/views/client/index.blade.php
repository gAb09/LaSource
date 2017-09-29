@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.client.index') }}</h1>
@stop


@section('content')

<div class="offset3 span11 flexcontainer">

	@foreach($models as $model)
{{-- LSProblem --}}
		<div class="fiche {{$model->class_actived}}" ondblClick = "javascript:document.location.href='http://lasource/client/{{ $model->id }}/edit';">

			<p class="lighten50">
				{{ $model->prenom }} {{ $model->nom }}<br />
			</p>
				{{ $model->tel }}<br />
				{{ $model->mobile }}<br />
				{{ $model->ad1 }}<br />
				@if($model->ad2)
				{{ $model->ad2 }}
				@endif
				{{ $model->cp }} {{ $model->ville }}<br />
				{{ $model->user->email }}


		</div>

	@endforeach

</div>

@stop
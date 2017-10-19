@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.client.index') }}</h1>
@stop


@section('content')

<div class=" index_clients offset3 span11 flexcontainer">

	@foreach($models as $model)
{{-- LSProblem --}}
		<div class="fiche {{$model->class_actived}}" ondblClick = "javascript:editClient({{ $model->id }} );">

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
				@if(!is_null($model->relais))
				<p>{{ $model->relais->nom }}</p>
				@endif


		</div>

	@endforeach

</div>

@stop

@section('script')
@parent
<script src="/js/client.js"></script>
@stop

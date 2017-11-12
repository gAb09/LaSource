@extends('layouts.app')


@section('modemploi')
	@if($mode == 'trashed')
	@else
	@endif
@endsection


@section('titre')
@parent
	@if($mode == 'trashed')
		<h1 class="titrepage">{{ trans('titrepage.relais.trashed') }}</h1>
	@else
		<h1 class="titrepage">{{ trans('titrepage.relais.index') }}</h1>
	@endif
@endsection


@section('topcontent1')
	@if($mode == 'trashed')
		<h1 class="titrepage">{{ trans('titrepage.relais.trashed') }}</h1>
	@else
		<h1 class="titrepage">{{ trans('titrepage.relais.index') }}</h1>
		<a href="{{ route('relais.create') }}" class="btn-xs btn-primary">
			Créer un relais
		</a>
	@endif
@endsection


@section('content')
<div id="relaiss_index" class="offset3 span11 flexcontainer">
	@forelse($models as $model)
		@include('relais.show')
	@empty 
		@if($mode == 'trashed')
			<h3>Aucun relais supprimé
				@include('shared.button.index', ['modelName' => 'relais', 'buttonEtiquette' => 'Retour à la liste'])
			</h3>
		@endif
	@endforelse
</div>
@endsection


@section('script')
@parent
<script src="/js/relais.js"></script>
@endsection
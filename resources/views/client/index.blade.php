@extends('layouts.app')


@section('modemploi')
	@if($mode == 'trashed')
	@else
	@endif
@endsection


@section('titre')
@parent
	@if($mode == 'trashed')
		<h1 class="titrepage">{{ trans('titrepage.client.trashed') }}</h1>
	@else
		<h1 class="titrepage">{{ trans('titrepage.client.index') }}</h1>
	@endif
@endsection


@section('topcontent1')
	@if($mode == 'trashed')
		<h1 class="titrepage">{{ trans('titrepage.client.trashed') }}</h1>
	@else
		<h1 class="titrepage">{{ trans('titrepage.client.index') }}</h1>
		<a href="{{ route('client.create') }}" class="btn-xs btn-primary is_error_txt">
			Créer un client
		</a>
	@endif
@endsection


@section('content')
<div id="clients_index" class="offset3 span11 flexcontainer">
	@forelse($models as $model)
		@include('client.show')
	@empty 
		@if($mode == 'trashed')
			<h3>Aucun client supprimé
				@include('shared.button.index', ['modelName' => 'client', 'buttonEtiquette' => 'Retour à la liste'])
			</h3>
		@endif
	@endforelse
</div>
@endsection


@section('script')
@parent
<script src="/js/client.js"></script>
@endsection

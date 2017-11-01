@extends('layouts.app')


@section('modemploi')
	@if($mode == 'trashed')
	@else
	@endif
@stop


@section('titre')
@parent
	@if($mode == 'trashed')
		<h1 class="titrepage">{{ trans('titrepage.modepaiement.trashed') }}</h1>
	@else
		<h1 class="titrepage">{{ trans('titrepage.modepaiement.index') }}</h1>
	@endif
@stop


@section('topcontent1')
	@if($mode == 'trashed')
		<h1 class="titrepage">{{ trans('titrepage.modepaiement.trashed') }}</h1>
	@else
		<h1 class="titrepage">{{ trans('titrepage.modepaiement.index') }}</h1>
		<a href="{{ route('modepaiement.create') }}" class="btn-xs btn-primary">
			Créer un mode de paiement
		</a>
	@endif
@stop


@section('content')
<div id="modepaiements_index" class="offset3 span11 flexcontainer">
	@forelse($models as $model)
		@include('modepaiement.show')
	@empty 
		@if($mode == 'trashed')
			<h3>Aucun mode de paiement supprimé
				@include('shared.button.index', ['modelName' => 'modepaiement', 'buttonEtiquette' => 'Retour à la liste'])
			</h3>
		@endif
	@endforelse
</div>
@stop


@section('script')
@parent
<script src="/js/modepaiement.js"></script>
@stop
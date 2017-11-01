@extends('layouts.app')


@section('modemploi')
	@if($mode == 'trashed')
	@else
	@endif
@stop


@section('titre')
@parent
	@if($mode == 'trashed')
		<h1 class="titrepage">{{ trans('titrepage.panier.trashed') }}</h1>
	@else
		<h1 class="titrepage">{{ trans('titrepage.panier.index') }}</h1>
	@endif
@stop


@section('topcontent1')
	@if($mode == 'trashed')
		<h1 class="titrepage">{{ trans('titrepage.panier.trashed') }}</h1>
	@else
		<h1 class="titrepage">{{ trans('titrepage.modepaiement.index') }}</h1>
		<a href="{{ route('panier.create') }}" class="btn-xs btn-primary">
			Créer un panier
		</a>
	@endif
@stop


@section('content')
<div id="paniers_index" class="offset3 span11 flexcontainer">
	@forelse($models as $model)
		@include('panier.show')
	@empty 
		@if($mode == 'trashed')
			<h3>Aucun panier supprimé
				@include('shared.button.index', ['modelName' => 'panier', 'buttonEtiquette' => 'Retour à la liste'])
			</h3>
		@endif
	@endforelse
</div>
@stop


@section('script')
@parent
<script src="/js/panier.js"></script>
@stop
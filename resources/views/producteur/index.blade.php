@extends('layouts.app')


@section('modemploi')
	@if($mode == 'trashed')
	@else
	@endif
@stop


@section('titre')
@parent
	@if($mode == 'trashed')
		<h1 class="titrepage">{{ trans('titrepage.producteur.trashed') }}</h1>
	@else
		<h1 class="titrepage">{{ trans('titrepage.producteur.index') }}</h1>
	@endif
@stop


@section('topcontent1')
	@if($mode == 'trashed')
		<h1 class="titrepage">{{ trans('titrepage.producteur.trashed') }}</h1>
	@else
		<h1 class="titrepage">{{ trans('titrepage.producteur.index') }}</h1>
		<a href="{{ route('producteur.create') }}" class="btn-xs btn-primary">
			Créer un mode de paiement
		</a>
	@endif
@stop


@section('content')
<div id="producteurs_index" class="offset3 span11 flexcontainer">
	@forelse($models as $model)
		@include('producteur.show')
	@empty 
		@if($mode == 'trashed')
			<h3>Aucun producteur supprimé
				@include('shared.button.index', ['modelName' => 'producteur', 'buttonEtiquette' => 'Retour à la liste'])
			</h3>
		@endif
	@endforelse
</div>
@stop
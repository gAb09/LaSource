@extends('layouts.app')

@section('titre')
@parent
@stop



@section('topcontent1')
<h1 class="titrepage">{{ trans('titrepage.panier.index') }}</h1>

<a href="{{ route('panier.create') }}" class="btn-xs btn-primary"> <i class="fa fa-btn fa-trash-o"></i>Créer un panier</a>
@stop


@section('content')
<div id="paniers_index" class="offset3 span11 flexcontainer">
	@forelse($models as $model)
		@include('panier.show')
	@empty 
		<h3>Aucun panier supprimé
			@include('shared.button.index', ['modelName' => 'panier', 'buttonEtiquette' => 'Retour à la liste'])
		</h3>
	@endforelse
</div>

@stop


@section('script')
@parent
<script src="/js/panier.js"></script>
@stop
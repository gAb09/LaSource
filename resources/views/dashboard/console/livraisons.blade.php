<div id="dash_listes_livraisons">
	<h3>{{ trans_choice('message.livraison.ouvertes', $livraisons->count(), [ 'count' => $livraisons->count() ]) }}</h3>

@foreach($livraisons as $livraison)

	<p>
		@date_complete($livraison->date_livraison)<br />
		{{trans('constante.'.$livraison->statut)}}
	</p>

@endforeach
</div>
<div id="dash_console_livraisons" class="livraison">
	<p>{{ trans_choice('message.livraison.ouvertes_listeDashboard', $livraisons->count(), [ 'count' => $livraisons->count() ]) }}
		<small role="handleAllLivraisons" class="hidden" onClick="javascript:afficherAllLivraisons()"><br />Les afficher toutes</small>
	</p>

	@foreach($livraisons as $livraison)

	<p>
		@date_eB($livraison->date_livraison) <small>({{trans('statuts.'.$livraison->statut)}})</small><br />
		<small role="handleOneLivraison" class="affiche_masque masquer"  onClick="javascript:afficherMasquerUneLivraison( this, {{ $livraison->id }} )"></small>
	</p>

	@endforeach
</div>

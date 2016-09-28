<button class="btn addIndisponibilite" onClick="javascript:addIndisponibilite('{{ route("addIndisponibilite", ['indisponible_type' => $model_classe, 'indisponible_id' => $model_id]) }}')">
	<i class="fa fa-btn fa-calendar-plus-o">
	</i>
	<div class="etiquette">Ajouter une période d’indisponibilité</div>
</button>
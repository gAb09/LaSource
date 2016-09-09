<button class="btn addIndisponibilite" onClick="javascript:addIndisponibilite('{{ route("addIndisponibilite", ['id' => $model_id, 'model_classe' => $model_classe]) }}')">
	<i class="fa fa-btn fa-calendar-plus-o">
	</i>
	<div class="etiquette">Ajouter une période d’indisponibilité</div>
</button>
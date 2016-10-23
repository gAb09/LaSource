<button class="btn addIndisponibilite" onClick="javascript:addIndisponibilite('{{ route("addIndisponibilite", ['indisponisable_type' => $model_classe, 'indisponisable_id' => $model_id]) }}')">
	<i class="fa fa-btn fa-calendar-plus-o">
	</i>
	<div class="etiquette">Ajouter une période d’indisponibilité</div>
</button>
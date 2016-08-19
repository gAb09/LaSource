<button class="btn createFermeture" onClick="javascript:createFermeture('{{ route('fermeture.create', ['model' => $model, 'model_id' => $model_id]) }}')">
	<i class="fa fa-btn fa-lock">
	</i>
	<div class="etiquette">Ajouter une fermeture</div>
</button>
@if($is_actived)
	<button id="activation_button_{{ $model->id }}" class="btn activation" onClick="javascript:desactive('{{$model_class}}', {{$id}});">
		<i id="activation_icone_{{ $model->id }}" class="fa fa-btn fa-check-square-o">
		</i>
		<div id="activation_etiquette_{{ $model->id }}" class="etiquette">Désactiver</div>
	</button>
@else
	<button id="activation_button_{{ $model->id }}" class="btn activation" onClick="javascript:active('{{$model_class}}', {{$id}});">
		<i id="activation_icone_{{ $model->id }}" class="fa fa-btn fa-square-o">
		</i>
		<div id="activation_etiquette_{{ $model->id }}" class="etiquette">Activer</div>
	</button>
@endif
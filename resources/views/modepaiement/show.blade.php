<div  id="fiche_{{$model->id}}" class="fiche stickycontainer {{$model->class_actived}}" ondblClick = "javascript:editModePaiement({{ $model->id }} );">

	<div class="allowstickyfooter">


		<p class="lighten50 inset_shadow">
			<strong>{!! $model->nom !!}</strong><br />
		</p>

		<p class="remarques">
			{!! $model->remarques !!}
		</p>

		<p class="hidden id">{{ $model->id }}</p> {{-- surtout pas de CR dans cette ligne --}}

		<p class="hidden rang">
			rang : {{ $model->rang }}
		</p>
	</div>


	<div class="footer flexcontainer">
		@if($mode == 'index')
			@include('layouts.button.supp', ['model' => 'modepaiement', 'model_id' => $model->id, 'text_confirm' => trans('message.modepaiement.confirmDelete', ['model' => "$model->nom"]) ])
			@include('layouts.button.edite', ['model' => 'modepaiement', 'model_id' => $model->id])
		@else
			@include('layouts.button.restore', ['buttonEtiquette' => 'mode de paiement', 'model' => 'modepaiement', 'model_id' => $model->id])
		@endif
	</div>

</div>


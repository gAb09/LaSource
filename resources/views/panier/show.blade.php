<div id="fiche_{{$model->id}}" class="fiche stickycontainer {{$model->class_actived}}" ondblClick = "javascript:editPanier( {{ $model->id }} );">

	<div class="allowstickyfooter">

		<p class="lighten66 inset_shadow">{{ $model->type }}<br />
			<strong>{!! $model->nom_court !!}</strong>
		</p>

		<p class="" style="font-style:italic">
			{!! $model->idee !!}
		</p>

		<p class="lighten50 inset_shadow">
			{!! $model->nom !!}<br />
		</p>

		<p>
			<strong>@prixFR($model->prix_base)</strong>
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
			@include('layouts.button.supp', ['model' => 'panier', 'model_id' => $model->id, 'text_confirm' => trans('message.panier.confirmDelete', ['model' => "$model->nom_court"]) ])
			@include('layouts.button.edite', ['model' => 'panier', 'model_id' => $model->id])
			@include('layouts.button.index.activation', ['model_class' => 'panier', 'is_actived' => $model->is_actived, 'id' => $model->id])
		@else
			@include('layouts.button.restore', ['buttonEtiquette' => 'panier', 'model' => 'panier', 'model_id' => $model->id])
		@endif
	</div>

</div>

<div  id="fiche_{{$model->id}}" class="fiche stickycontainer {{$model->class_actived}}" ondblClick = "javascript:editProducteur( {{ $model->id }} );">

	<div class="allowstickyfooter">

		<p class="lighten66 inset_shadow">{{ $model->exploitation }}<br />
			{{ $model->prenom }} {{ $model->nom }}
		</p>
		<p><strong>{{ $model->nompourpaniers }}</strong></p>
		<p class="lighten50 inset_shadow">
			{{ $model->tel }}<br />
			{{ $model->mobile }}<br />
			{{ $model->ad1 }}<br />
			@if($model->ad2)
			{{ $model->ad2 }}<br />
			@endif
			{{ $model->cp }} {{ $model->ville }}<br />
			{{ $model->email }}
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
			@include('layouts.button.supp', ['model' => 'producteur', 'model_id' => $model->id, 'text_confirm' => trans('message.producteur.confirmDelete', ['model' => "$model->nompourpaniers"]) ])
			@include('layouts.button.edite', ['model' => 'producteur', 'model_id' => $model->id])
			@include('layouts.button.index.activation', ['model_class' => 'producteur', 'is_actived' => $model->is_actived, 'id' => $model->id])
		@else
			@include('layouts.button.restore', ['buttonEtiquette' => 'producteur', 'model' => 'producteur', 'model_id' => $model->id])
		@endif
	</div>

</div>
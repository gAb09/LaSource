<div id="producteurs_index" class="offset3 span11 flexcontainer">
	@forelse($models as $model)
{{-- LSProblem --}}
	<div class="fiche stickycontainer {{$model->class_actived}}" ondblClick = "javascript:editProducteur( {{ $model->id }} );">

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
			@if(!isset($trashed))
			@include('layouts.button.supp', ['model' => 'producteur', 'model_id' => $model->id, 'text_confirm' => trans('message.producteur.confirmDelete', ['model' => "$model->nompourpaniers"]) ])
			@endif
			@include('layouts.button.edite', ['model' => 'producteur', 'model_id' => $model->id])
		</div>

	</div>
	@empty 
	<h3>Aucun producteur supprimé
		@include('shared.button.index', ['modelName' => 'producteur', 'buttonEtiquette' => 'Retour à la liste'])
	</h3>
	@endforelse

</div>

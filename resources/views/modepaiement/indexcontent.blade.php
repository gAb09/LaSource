<div id="modepaiements_index" class="offset3 span11 flexcontainer">
	@forelse($models as $model)
{{-- LSProblem --}}
	<div class="fiche stickycontainer {{$model->class_actived}}" ondblClick = "javascript:document.location.href='http://lasource/modepaiement/{{ $model->id }}/edit';">

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
			@if(!isset($trashed))
			@include('layouts.button.supp', ['model' => 'modepaiement', 'model_id' => $model->id, 'text_confirm' => trans('message.modepaiement.confirmDelete', ['model' => "$model->nom"]) ])
			@endif
			@include('layouts.button.edite', ['model' => 'modepaiement', 'model_id' => $model->id])
		</div>

	</div>
	@empty 
	<h3>Aucun mode de paiement supprimé
		@include('shared.button.index', ['modelName' => 'modepaiement', 'buttonEtiquette' => 'Retour à la liste'])
	</h3>
	@endforelse
</div>


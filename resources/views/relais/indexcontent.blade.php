<div id="relaiss_index" class="offset3 span11 flexcontainer">
	@forelse($models as $model)
	<div class="fiche stickycontainer {{$model->class_actif}}" ondblClick = "javascript:document.location.href='http://lasource/relais/{{ $model->id }}/edit';">

		<div class="allowstickyfooter">

			<p class="lighten66 inset_shadow">
				<strong>{{ $model->ville }}</strong><br />
				{{ $model->tel }}<br />
			</p>
			<p>
				{{ $model->retrait }}
			</p>
			<p class="lighten50 inset_shadow">
				{{ $model->nom }}<br />
				{{ $model->ad1 }}<br />
				@if($model->ad2)
				{{ $model->ad2 }}<br />
				@endif
				{{ $model->cp }} {{ $model->ville }}<br />
				{{ $model->email }}
				<p>{{ $model->ouvertures }}</p>
			</p>

			<p class="remarques">{{ $model->remarques }}</p>

			<p class="hidden id">{{ $model->id }}</p> {{-- surtout pas de CR dans cette ligne --}}

			<p class="hidden rang">
				rang : {{ $model->rang }}
			</p>
		</div>

		<div class="fermetures">
			@if(!$model->fermetures->isEmpty())
				@foreach($model->fermetures as $fermeture)
					Fermeture pour cause de 
					<strong>{{ $fermeture->pivot->cause }}</strong>
					<br />du {{ $fermeture->date_debut_enclair }}
					<br />au 
					{{ $fermeture->date_fin_enclair }}
					<br />
					<p class="remarques">
						{{ $fermeture->pivot->remarques }}
					</p>
				@endforeach
			@endif
		</div>
		
		<div class="footer flexcontainer">
			@if(!isset($trashed))
			@include('layouts.button.supp', ['model' => 'relais', 'model_id' => $model->id, 'text_confirm' => trans('message.relais.confirmDelete', ['model' => "$model->nom"]) ])
			@endif
			@include('layouts.button.edite', ['model' => 'relais', 'model_id' => $model->id])
			@include('layouts.button.createFermeture', ['model' => 'relais', 'model_id' => $model->id])
		</div>
		
	</div>
	@empty 
	<h3>Aucun relais supprimé
		@include('shared.button.index', ['modelName' => 'relais', 'buttonEtiquette' => 'Retour à la liste'])
	</h3>
	@endforelse

</div>

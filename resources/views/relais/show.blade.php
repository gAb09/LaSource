<div class="fiche stickycontainer {{$model->class_actived}}" ondblClick = "javascript:editRelais( {{ $model->id }} );">

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

	@if(!$model->indisponibilites->isEmpty())
	<div class="lighten66 inset_shadow indisponibilites">
		@foreach($model->indisponibilites as $indisponibilite)
			Indisponible pour cause de 
			<strong>{{ $indisponibilite->cause }}</strong>
			<br />du @date_complete($indisponibilite->date_debut)
			<br />au 
			@date_complete($indisponibilite->date_fin)
			<br />
			<p class="remarques">
				{{ $indisponibilite->remarques }}
			</p>
			<p>
				@include('layouts.button.edite', ['model' => 'indisponibilite', 'model_id' => $indisponibilite->id])
				@include('layouts.button.supp', ['model' => 'indisponibilite', 'model_id' => $indisponibilite->id, 'text_confirm' => trans('message.indisponibilite.confirmDelete', ['model' => ""]) ])
			</p>
		@endforeach
	</div>
	@endif
	
	<div class="footer flexcontainer">
		@if($mode == 'index')
			@include('layouts.button.supp', ['model' => 'relais', 'model_id' => $model->id, 'text_confirm' => trans('message.relais.confirmDelete', ['model' => "$model->nom"]) ])
			@include('layouts.button.edite', ['model' => 'relais', 'model_id' => $model->id])
			@include('layouts.button.addIndisponibilite', ['model_classe' => 'Relais', 'model_id' => $model->id])
		@else
			@include('layouts.button.restore', ['buttonEtiquette' => 'relais', 'model' => 'relais', 'model_id' => $model->id])
		@endif
	</div>
	
</div>
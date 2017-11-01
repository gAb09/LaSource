		<div class="fiche {{$model->class_actived}}" ondblClick = "javascript:editClient({{ $model->id }} );">

			<p class="lighten50">
				{{ $model->prenom }} {{ $model->nom }}<br />
			</p>
				{{ $model->tel }}<br />
				{{ $model->mobile }}<br />
				{{ $model->ad1 }}<br />
				@if($model->ad2)
				{{ $model->ad2 }}
				@endif
				{{ $model->cp }} {{ $model->ville }}<br />
				{{ $model->user->email }}
				@if(!is_null($model->relais))
				<p>{{ $model->relais->nom }}</p>
				@endif


		</div>

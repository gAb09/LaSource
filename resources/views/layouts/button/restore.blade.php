<form class="form-inline" role="form" method="GET" action="{{ route($model.'.restore', [$model_id]) }}">
	{!! csrf_field() !!}

	<button class="btn-xs btn-success"> <i class="fa fa-btn fa-check"></i>Restaurer ce {{$buttonEtiquette}}
	</button>
</form>
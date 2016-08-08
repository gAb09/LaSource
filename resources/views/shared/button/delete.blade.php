<form class="form-inline" role="form" method="POST" action="{{ route($modelName.'.destroy', $model->id) }}">
	{!! csrf_field() !!}
	<input type="hidden" class="form-control" name="_method" value="DELETE">

	<button class="btn-xs btn-danger"> <i class="fa fa-btn fa-trash-o"></i>Supprimer ce {{$buttonEtiquette.'.test'}}
	</button>
</form>
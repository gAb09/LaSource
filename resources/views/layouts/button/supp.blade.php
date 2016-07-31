<form action="{{ route($model.'.destroy', [$model_id]) }}" method="post" onsubmit="return confirm('{{ $text_confirm }}');">
	{!! csrf_field() !!}
	<input type="text" class="hidden" name="_method" value="delete">
	<button class="supp">
		<i class="fa fa-btn fa-trash-o">
		</i>
	</button>
</form>

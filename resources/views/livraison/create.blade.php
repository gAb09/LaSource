<form class="form-inline" role="form" method="POST" action="{{ route('livraison.store') }}">
	{!! csrf_field() !!}
	<div 
	class="flexcontainer ligne_livraison"
	id="row_{{ $item->id }}" 
	>


	@include('livraison.form')

	<button type="submit" class="btn btn-xs btn-primary">
		<i class="fa fa-btn fa-user"></i>Valider
	</button>

</div>

</form>

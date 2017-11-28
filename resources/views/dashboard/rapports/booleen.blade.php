<a onClick="javascript:toggleBooleanProperty( this, '{{ $model }}', {{ $id }}, '{{ $property }}' )">
	@if($valeur == true)
		<i class="booleen fa fa-btn fa-check-square"></i>
	@else
		<i class="booleen fa fa-btn fa-square-o"></i> 
	@endif
</a>

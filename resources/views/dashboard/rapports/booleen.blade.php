<a type="submit" class="booleen" onClick="javascript:toggleBoolean(this, '{{ $model }}', {{ $id }}, '{{ $property }}', {{ $valeur }})">
	@if($valeur == true)
		<i class="booleen fa fa-btn fa-check-square"></i>
	@else
		<i class="booleen fa fa-btn fa-square-o"></i> 
	@endif
</a>

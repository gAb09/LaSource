@extends('layouts.app')

@section('titre')
@parent
@stop


@section('message')
@parent
@include('livraison.errors')
@stop


@section('topcontent1')
@stop


@section('topcontent2')
@include('livraison.modemploi')
@stop


@section('content')

<div class="col-md-12">
	@section('globalform_action')
	@show

	<!-- Les dates -->
	<div class="col-md-12 flexcontainer form_dates">
		@include('livraison.form_dates')
	</div>

	<!-- Les paniers -->
	<div class="col-md-12 flexcontainer form_paniers">
		@include('livraison.form_paniers')
	</div>

	<div class="col-md-12 flexcontainer livraison_footer">
		<button type="submit" class="btn  btn-success">
			<i class="fa fa-btn fa-save"></i>Valider cette livraison
		</button>
	</div>
</div>


</form>

<button type="submit" class="btn btn-info">
	<i class="fa fa-btn fa-list-ul"></i>Retour à la liste
</button>

<button type="submit" class="btn btn-primary">
	<i class="fa fa-btn fa-envelope"></i>Préparer mail pour clients
</button>

</div>

@stop
@section('script')
@stop

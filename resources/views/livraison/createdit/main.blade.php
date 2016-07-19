@extends('layouts.app')

@section('modal')
<div class="modal fade" id="ModallistPaniers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
</div>

{{-- @include('livraison.modales.EditPanier') --}}

<div class="modal fade" id="ModallistProducteursForPanier" tabindex="-1" role="dialog" aria-labelledby="ModallistProducteursForPanierLabel">
</div><!-- /.modal -->

@show


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

<div class="createdit container-fluid">
	@section('createdit')
	@show
</div>

<div class="container-fluid flexcontainer" style="justify-content:space-around">
	<a href="{{ URL::route('livraison.index') }}" class="btn btn-info">
		<i class="fa fa-btn fa-list-ul"></i>Retour à la liste
	</a>

	<a type="submit" class="btn btn-primary">
		<i class="fa fa-btn fa-envelope"></i>Gérer les mails pour cette livraison
	</a>
</div>

@stop

@section('script')
@parent
<script src="/js/livraison.js"></script>

<script type="text/javascript">

var clot = "{{ old('date_cloture', $item->date_cloture) }}";
clot = clot.split(" ")[0];
getComboDate('date_cloture', clot);

var paie = "{{ old('date_paiement', $item->date_paiement) }}";
paie = paie.split(" ")[0];
getComboDate('date_paiement', paie);

var liv = "{{ old('date_livraison', $item->date_livraison) }}";
liv = liv.split(" ")[0];
getComboDate('date_livraison', liv);

</script>
@stop

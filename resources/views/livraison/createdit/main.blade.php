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
@stop


@section('topcontent1')
@parent
	<a href="{{ URL::route('livraison.index') }}" class="btn btn-info">
		<i class="fa fa-btn fa-list-ul"></i>Retour à la liste
	</a>
@stop


@section('topcontent2')
@include('livraison.modemploi')
@stop


@section('content')

<div class="createdit container-fluid">
	@section('createdit')
	@show
</div>



@stop

@section('script')
@parent
<script src="/js/livraison.js"></script>

<script type="text/javascript">

getComboDate('date_cloture', "{{ old('date_cloture', $model->date_cloture) }}");

var paie = "{{ old('date_paiement', $model->date_paiement) }}";
paie = paie.split(" ")[0];
getComboDate('date_paiement', paie);

var liv = "{{ old('date_livraison', $model->date_livraison) }}";
liv = liv.split(" ")[0];
getComboDate('date_livraison', liv);

</script>
@stop

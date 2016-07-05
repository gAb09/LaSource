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
	@section('createOrEdit')
	@show
</div>


<a href="{{ URL::route('livraison.index') }}" class="btn btn-info">
	<i class="fa fa-btn fa-list-ul"></i>Retour à la liste
</a>

<a type="submit" class="btn btn-primary">
	<i class="fa fa-btn fa-envelope"></i>Préparer mail pour clients
</a>

</div>

@stop

@section('script')
@stop

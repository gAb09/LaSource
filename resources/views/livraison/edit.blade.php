@extends('livraison.handle')

@section('titre')
@parent
@stop


@section('message')
@parent
@stop


@section('topcontent1')
<h1 class="titrepage">{!! trans('titrepage.livraison.edit', ['date_titrepage' => $date_titrepage]) !!}</h1>
@stop


@section('topcontent2')
@parent
@stop


@section('globalform_action')

<form class="form-inline" role="form" method="POST" action="{{ route('livraison.update', $item->id) }}">
	{!! csrf_field() !!}
	<input type="hidden" class="form-control" name="_method" value="PUT">

@stop
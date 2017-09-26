@extends('menus/views/layout')

@section('titre')
@parent
@stop


@section('topcontent1')
		<h1 class="titrepage">{{$titre_page}}</h1>
@stop


@section('topcontent2')
@stop


@section('contenu')

	{{ Form::open(array('url' => URL::action('MenuController@store'), 'method' => 'post')) }}

@include('menus/views/form')


@stop

@section('zapette')
{{ link_to_action('MenuController@index', 'Retour à la liste', null, array('class' => 'btn btn-info btn-zapette iconesmall list')); }}

{{ Form::submit('Créer ce menu', array('class' => 'btn btn-success')) }}
{{ Form::close() }}
@stop


@section('footer')
@parent
<h3>  Le footer de menus</h3>

@stop
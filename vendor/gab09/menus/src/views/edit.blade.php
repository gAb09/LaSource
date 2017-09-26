@extends('menus/views/layout')

@section('titre')
@parent
@stop


@section('topcontent1')
		<h1 class="titrepage">{{$titre_page}} “{{$menu->etiquette}}” <small>(Id {{$menu->id}})</small></h1>
@stop


@section('topcontent2')
@stop


@section('contenu')

{{ Form::model($menu, ['method' => 'PUT', 'route' => ['admin.menus.update', $menu->id]]) }}

@include('menus/views/form')

@stop



@section('zapette')
{{ link_to_action('MenuController@index', 'Retour à la liste', null, array('class' => 'btn btn-info btn-zapette iconesmall list')); }}

{{ Form::submit('Modifier ce menu', array('class' => 'btn btn-edit btn-zapette')) }}
{{ Form::close() }}

{{ Form::open(['method' => 'delete', 'action' => ['MenuController@destroy', $menu->id]]) }}
{{ Form::submit('Supprimer ce menu', array('class' => 'btn btn-danger', 'onClick' => 'javascript:return(confirmation());')) }}
{{ Form::close() }}
@stop

@section('footer')
@parent
<h3>  Le footer de menus</h3>

@stop
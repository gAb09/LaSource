@extends('menus/views/layout')

@section('titre')
@parent
@endsection


@section('topcontent1')
		<h1 class="titrepage">{{$titre_page}} “{{$menu->etiquette}}” <small>(Id {{$menu->id}})</small></h1>
@endsection


@section('topcontent2')
@endsection


@section('contenu')

{{ Form::model($menu, ['method' => 'PUT', 'route' => ['admin.menus.update', $menu->id]]) }}

@include('menus/views/form')

@endsection



@section('zapette')
{{ link_to_action('MenuController@index', 'Retour à la liste', null, array('class' => 'btn btn-info btn-zapette iconesmall list')); }}

{{ Form::submit('Modifier ce menu', array('class' => 'btn btn-edit btn-zapette')) }}
{{ Form::close() }}

{{ Form::open(['method' => 'delete', 'action' => ['MenuController@destroy', $menu->id]]) }}
{{ Form::submit('Supprimer ce menu', array('class' => 'btn btn-danger', 'onClick' => 'javascript:return(confirmation());')) }}
{{ Form::close() }}
@endsection

@section('footer')
@parent
<h3>  Le footer de menus</h3>

@endsection
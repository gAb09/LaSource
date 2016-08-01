@extends('layouts.app')

@section('topcontent2')
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{ trans('titrepage.relais.edit', ['nom' => $model->nom]) }}</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline" role="form" method="POST" action="{{ route('relais.update', $model->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="PUT">

                        @include('relais.form')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Valider les modifications
                                </button>
                            </div>
                        </div>
                    </form>

                    <form class="form-inline" role="form" method="POST" action="{{ route('relais.destroy', $model->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="DELETE">

                        <button class="btn-xs btn-danger"> <i class="fa fa-btn fa-trash-o"></i>Supprimer ce relais
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

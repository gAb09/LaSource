@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{ trans('titrepage.relais.create') }}</h3>
                    @include('shared.button.index', ['modelName' => 'relais', 'buttonEtiquette' => 'Retour à la liste'])
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('relais.store') }}">
                        {!! csrf_field() !!}

                        @include('relais.form')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Valider les modifications
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

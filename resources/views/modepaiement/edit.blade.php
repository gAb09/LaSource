@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{ trans('titrepage.modepaiement.edit', ['nom' => $model->nom]) }}</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline" role="form" method="POST" action="{{ route('modepaiement.update', $model->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="PUT">

                        @include('modepaiement.form')

                        <div class="form-group">
                            <div class="col-md-5 col-md-offset-1">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-edit"></i>Valider les modifications
                                </button>
                            </div>
                        </div>
                    </form>

                    <form class="form-inline" role="form" method="POST" action="{{ route('modepaiement.destroy', $model->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="DELETE">

                        <button class="btn-xs btn-danger"> <i class="fa fa-btn fa-trash-o"></i>Supprimer ce mode de paiement
                        </button>
                    </form>

                </div> 
            </div>
        </div>
    </div>
</div>
@endsection


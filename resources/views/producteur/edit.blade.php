@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{ trans('titrepage.producteur.edit', ['exploitation' => $model->exploitation]) }}</h3>
                    @include('producteur.button.index', ['etiquette' => 'Retour à la liste'])
                </div>
                <div class="panel-body producteur">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('producteur.update', $model->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="PUT">
                        <p class="rappel_id">Producteur n° {{ $model->id }}</p>

                        @include('producteur.form')

                        <div class="form-group">
                            <div class="col-md-5 col-md-offset-1">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-edit"></i>Valider les modifications
                                </button>
                            </div>
                        </div>
                    </form>
                </div> 
            </div>
            @include('producteur.button.delete')
        </div>
    </div>
</div>
@endsection


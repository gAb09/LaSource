@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{!! trans('titrepage.modepaiement.edit', ['nom' => $model->nom]) !!}</h3>
                    @include('shared.button.index', ['modelName' => 'modepaiement', 'buttonEtiquette' => 'Retour à la liste'])
                </div>
                <div class="panel-body modepaiement">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('modepaiement.update', $model->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="PUT">
                        <p class="rappel_id">modepaiement n° {{ $model->id }}</p>
                        @include('modepaiement.form')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button  type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-edit"></i>Valider les modifications
                                </button>
                            </div>
                        </div>
                    </form>
                </div> 
            </div>
            @include('shared.button.delete', ['modelName' => 'modepaiement', 'buttonEtiquette' => 'modepaiement'])
        </div>
    </div>
</div>
@endsection


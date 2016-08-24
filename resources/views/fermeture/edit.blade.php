@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 style="text-align:center">{!! $titre_page !!}</h3>
                    @include('layouts.button.previous_url', ['buttonEtiquette' => 'Retour page précédente'])
                </div>
                <div class="panel-body">
                    <form class="form-horizontal form_fermeture" role="form" method="POST" action="{{ route('fermeture.update', $model->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="PUT">

                        @include('fermeture.form')

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
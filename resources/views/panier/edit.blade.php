@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{!! trans('titrepage.panier.edit', ['nom_court' => $item->nom_court, 'type' => $item->type]) !!}</h3>
                    @include('panier.button.index', ['etiquette' => 'Retour à la liste'])
                </div>
                <div class="panel-body panier">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('panier.update', $item->id) }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="PUT">

                        @include('panier.form')

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
            @include('panier.button.delete')
        </div>
    </div>
</div>
@endsection


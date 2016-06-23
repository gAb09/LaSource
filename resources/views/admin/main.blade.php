@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Administration</h3>
                </div>
                <div class="panel-body">
                    {{Html::linkAction('OMController@transfertRelais', 'Transfert des relais')}}<br />
                    {{Html::linkAction('RelaisController@index', 'Les relais')}}<br />
                    <br />
                    {{Html::linkAction('OMController@transfertProducteur', 'Transfert des producteurs')}}<br />
                    {{Html::linkAction('ProducteurController@index', 'Les producteurs')}}<br />
                    <br />
                    {{Html::linkAction('OMController@transfertPanier', 'Transfert des paniers')}}<br />
                    {{Html::linkAction('PanierController@index', 'Les paniers')}}<br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

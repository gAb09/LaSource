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
                    <br />
                    {{Html::linkAction('OMController@transfertProducteur', 'Transfert des producteurs')}}<br />
                    <br />
                    {{Html::linkAction('OMController@transfertPanier', 'Transfert des paniers')}}<br />
                    <br />
                    {{Html::linkAction('OMController@transfertLivraison', 'Transfert des livraisons')}}<br />
                    <br />
                    {{Html::linkAction('OMController@transfertCommandes', 'Transfert des commandes')}}<br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
                    {{Html::linkAction('TransfertController@transfertRelais', 'Transfert des relais')}}<br />
                    <br />
                    {{Html::linkAction('TransfertController@transfertProducteur', 'Transfert des producteurs')}}<br />
                    <br />
                    {{Html::linkAction('TransfertController@transfertPanier', 'Transfert des paniers')}}<br />
                    <br />
                    {{Html::linkAction('TransfertController@transfertLivraison', 'Transfert des livraisons')}}<br />
                    <br />
                    {{Html::linkAction('TransfertController@transfertCommandes', 'Transfert des commandes')}}<br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
                    {{Html::linkAction('TransfertController@relais', 'Transfert des relais')}}<br />
                    <br />
                    {{Html::linkAction('TransfertController@tproducteurs', 'Transfert des producteurs')}}<br />
                    <br />
                    {{Html::linkAction('TransfertController@paniers', 'Transfert des paniers')}}<br />
                    <br />
                    {{Html::linkAction('TransfertController@livraisons', 'Transfert des livraisons')}}<br />
                    <br />
                    {{Html::linkAction('TransfertController@commandes', 'Transfert des commandes')}}<br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

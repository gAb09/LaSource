@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">

                    @if (session('status'))
                        <div class="alert alert-danger">
                            {!! session('status') !!}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {!! session('success') !!}
                        </div>
                    @endif
                    
                    <h3>Administration</h3>
                </div>
                <div class="panel-body">
                    {{Html::linkAction('OMController@transfertRelais', 'Transfert des relais')}}<br />
                    {{Html::linkAction('RelaisController@index', 'Les relais')}}<br />
                    <br />
                    {{Html::linkAction('OMController@transfertRelais', 'Transfert des ____')}}<br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

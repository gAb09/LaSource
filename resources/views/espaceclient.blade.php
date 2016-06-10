@extends('layouts.app')

@section('content')
{{Session::pull('url.intended')}}

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Espace Client</div>

                <div class="panel-body">
                    You are logged in!
                    {{var_dump($client->nom)}}
                    {{var_dump($client->user->pseudo)}}
                    {{var_dump(env('MAIL_GEST_NAME'))}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

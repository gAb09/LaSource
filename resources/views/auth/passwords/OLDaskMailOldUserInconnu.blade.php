@extends('auth.askMailLayout')

@section('titre')
    Récupération de pseudo
@endsection

@section('action')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/transfert/OldLoginFailed') }}">
@endsection

@section('alert-danger')
@parent
    Nous n’avons pas trouvé le pseudo : {{$pseudo}}<br />
@endsection
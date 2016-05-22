@extends('auth.askMailForm')

@section('titre')
Réinitialiser mon mot de passe
@endsection

@section('action')
<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
@endsection

@section('messageTransfert')
@endsection


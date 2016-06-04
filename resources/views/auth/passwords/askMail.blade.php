@extends('auth.askMailLayout')

@section('titre')
Demande de réinitialisation des identifiants.
@endsection

@section('action')
<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
@endsection

@section('messageTransfert')
@endsection


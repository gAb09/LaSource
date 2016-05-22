@extends('auth.connexionForm')

@section('action')
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/transfert/OldLoginFailed') }}">
@endsection

@section('alert-danger')
@parent
    <p>
    Nous n’avons pas trouvé le pseudo : {{$pseudo}}<br />
    Nous pouvons vous le rappeller via un 
    <a href ="{{url('transfert/OldLoginFailed')}}">
    	mail de confirmation</a>.
    </p>
@endsection
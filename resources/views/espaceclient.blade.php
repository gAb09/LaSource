    @extends('layouts.app')

@section('content')

<div class="container espace_client">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

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
                    
                <div class="panel-heading">
                    <h2>Espace client de {{$user->Client->prenom}} {{$user->Client->nom}}</h2>
                </div>

                <div class="panel-body">

                    <h3>Mes coordonnées</h3>
                    {{ $user->Client->prenom }} {{ $user->Client->nom }} ({{ $user->pseudo }})<br />
                    {{ $user->Client->ad1 }}<br />
                    {{ $user->Client->ad2 }}<br />
                    {{ $user->Client->cp }} {{ $user->Client->ville }}<br />
                    Tél : {{ $user->Client->telephone }}<br />
                    Portable : {{ $user->Client->mobile }}<br />
                    Courriel : {{ $user->email }}<br />
                    Rôle : {{ $user->role->etiquette }}<br />
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

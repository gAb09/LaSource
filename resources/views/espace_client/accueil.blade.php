    @extends('layouts.app')

@section('content')

<div class="container espace_client">
    <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Espace client de &nbsp;{{$model->Client->prenom}} {{$model->Client->nom}}</h2>
                </div>

                <div class="panel-body col-md-3">
                    <h3>Mes coordonnées</h3>
                    {{ $model->Client->prenom }} {{ $model->Client->nom }}<br/><small>(Pseudo : {{ $model->pseudo }})</small><br />
                    {{ $model->Client->ad1 }}<br />
                    @if(!empty($model->Client->ad2))
                      {{ $model->Client->ad2 }}<br />
                    @endif
                    {{ $model->Client->cp }} {{ $model->Client->ville }}<br />
                    Tél : {{ $model->Client->tel }}<br />
                    Portable : {{ $model->Client->mobile }}<br />
                    Courriel : {{ $model->email }}<br />
                    Rôle : {{ $model->role->etiquette }}<br /><br />
                    <a href="{{ route('client.edit', $model->id) }}" class="btn btn-primary">Modifier mes coordonnées</a><br />
                    <a href="{{ route('user.edit', $model->id) }}" class="btn btn-primary">Modifier mes identifiants</a>
                </div>

                <div class="panel-body col-md-9">
                    @include('espace_client.mes_commandes')
                </div>

            </div>
    </div>
</div>
@endsection

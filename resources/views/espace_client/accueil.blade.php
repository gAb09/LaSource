@extends('layouts.app')


@section('content')

<div class="container-fluid espace_client">
    <div class="row">
        <div class="panel panel-default">
                    <h2 style="text-align:center">{{ trans_choice('message.livraison.ouvertes', $livraisons->count(), [ 'count' => $livraisons->count() ]) }}
                        {{ trans_choice('message.commande.encours', $commandes->count(), [ 'count' => $commandes->count() ]) }}
                    </h2>

            <div class="panel-body col-md-2" style="position:fixed">
                <h3>Mes coordonnées</h3>
                <h4>{{ $model->Client->prenom }} {{ $model->Client->nom }}<br/><small>(Pseudo : {{ $model->pseudo }})</small><br /></h4>
                {{ $model->Client->ad1 }}<br />
                @if(!empty($model->Client->ad2))
                {{ $model->Client->ad2 }}<br />
                @endif
                {{ $model->Client->cp }} {{ $model->Client->ville }}<br />
                Tél : {{ $model->Client->tel }}<br />
                Portable : {{ $model->Client->mobile }}<br />
                Courriel : {{ $model->email }}<br />
                Rôle : {{ $model->role->etiquette }}<br /><br />
                <a href="{{ route('client.edit', $model->id) }}" class="btn btn-primary btn-xs">Modifier mes coordonnées</a><br />
                <a href="{{ route('user.edit', $model->id) }}" class="btn btn-primary btn-xs" style="margin-top:5px">Modifier mes identifiants</a>

                <br/>
                <h3 style="margin-top:10px">Mes préférences</h3>
                @include('espace_client.paiement_relais', ['ref_livraison' => 0, 'par_defaut' => "par défaut"])
            </div>

            <div class="panel-body col-md-offset-2 col-md-10">
                <form id="commande_store" class="form-horizontal" role="form" method="POST" action="{{ route('commande.store', $model->id) }}">
                {!! csrf_field() !!}
                    

                    <div class="livraisons_ouvertes">
                        @forelse($livraisons as $livraison)
                            @include('espace_client.livraisons_ouvertes')
                        @empty
                            À ce jour, pas de livraison programmée
                        @endforelse
                    </div>
                    <div class="commandes">
                        @if($model->Client->Commandes->isEmpty())
                            Pas de commande
                        @else
                            @foreach($model->Client->Commandes as $commande)
                                @include('espace_client.mes_commandes')
                            @endforeach
                        @endif
                    </div>
                </form>
             </div>
        </div>
    </div>
</div>


@endsection

@section('script')
@parent
<script src="/js/espace_client.js"></script>
@stop
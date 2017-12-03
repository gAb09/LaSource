@extends('layouts.app')


@section('modal')
<div id="overlay">
    <div class="popup_block une_livraison_ouverte">
        <a class="close" href="#noWhere" onClick="javascript:$('#modification_livraison').empty()">
            <i class="btn_close fa fa-btn fa-close"></i>
        </a>
        <form id="commande_update" class="form-horizontal" role="form" method="POST" action="">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="_method" value="PUT">
            <div id="livraison_modified">
            </div>
            <button id="button_update" type="submit" class="btn btn-success">
                Valider mes modifications
            </button>
        </form>
    </div>
</div>
@endsection



@section('content')
<div class="container-fluid espace_client">
    <div class="row">
        <div class="panel panel-default">
                    <h2 style="text-align:center">{{ trans_choice('message.livraison.ouvertes', $livraisons->count(), [ 'count' => $livraisons->count() ]) }} à la commande
                        {{ trans_choice('message.commande.encours', count($commandes_en_cours), [ 'count' => count($commandes_en_cours) ]) }}
                    </h2>

            <div class="panel-body col-md-2">
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
                @include('espace_client.paiement_relais', ['ref_livraison' => 0, 'par_defaut' => "par défaut", 'modespaiement' => $all_modes, 'relaiss' => $all_relais])
            </div>

            <div class="panel-body col-md-10">
                <form id="commande_store" class="form-horizontal" role="form" method="POST" action="{{ route('commande.store', $model->id) }}">
                {!! csrf_field() !!}
                    

                    <div class="une_livraison_ouverte">
                        @foreach($livraisons as $livraison)
                            @include('espace_client.une_livraison_ouverte')
                        @endforeach
                    </div>
                    <div class="commandes">
                        @if($commandes->isEmpty())
                            Aucune commande trouvée
                        @else
                            @foreach($commandes as $commande) <!-- affichage des commandes en cours -->
                                @if($commande->en_cours)
                                <div class="une_commande" style="position:relative">
                                    @include('espace_client.une_commande', ['en_cours' => true])
                                </div>
                                @endif
                            @endforeach
                            <div id="show_commandes_archived" style="margin-top:10px" class="btn btn-info" onClick="javascript:toggleCommandesArchived();" >Voir mes commandes archivées</div>
                            <div id="hide_commandes_archived" style="margin-top:10px" class="btn btn-info hidden" onClick="javascript:toggleCommandesArchived();" >Masquer mes commandes archivées</div>
                            @foreach($commandes as $commande)  <!-- affichage des commandes archivées -->
                                @if(!$commande->en_cours)
                                <div id="une_commande_archive" class="hidden" style="position:relative">
                                    @include('espace_client.une_commande', ['en_cours' => false])
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                        <div id="change_detected" class="btn btn-warning hidden" style="float:right;">
                            <big>Vous êtes en train de faire des changements !!!</big><br />
                            Une fois que vous aurez fini, pensez à les  
                            <button class="btn btn-success btn-xs"  type="submit" >valider</button><br /> 
                            Sinon vous pouvez les 
                            <a class="btn btn-danger btn-xs" href="">annuler</a>

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
<script type="text/javascript">
window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
</script>
@endsection
@extends('layouts.app')


@section('modal')
<div id="overlay">
    <div class="popup_block une_livraison_ouverte">
        <a class="close" href="#noWhere" onClick="javascript:$('#modification_livraison').empty()">
            <i class="btn_close fa fa-btn fa-close"></i>
        </a>
        <form id="commande_update" class="form-horizontal" role="form" method="POST" action="{{ route('commande.update', '999') }}">
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
                <h4>{{ $user->Client->prenom }} {{ $user->Client->nom }}<br/><small>(Pseudo : {{ $user->pseudo }})</small><br /></h4>
                {{ $user->Client->ad1 }}<br />
                @if(!empty($user->Client->ad2))
                {{ $user->Client->ad2 }}<br />
                @endif
                {{ $user->Client->cp }} {{ $user->Client->ville }}<br />
                Tél : {{ $user->Client->tel }}<br />
                Portable : {{ $user->Client->mobile }}<br />
                Courriel : {{ $user->email }}<br />
                Rôle : {{ $user->role->etiquette }}<br /><br />
                <a href="{{ route('client.edit', $user->id) }}" class="btn btn-primary btn-xs">Modifier mes coordonnées</a><br />
                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-xs" style="margin-top:5px">Modifier mes identifiants</a>
                <a href="" class="btn btn-danger btn-xs" style="margin-top:5px;font-size:0.7em" onClick="javascript:alert('Fonctionnalité souhaitée ??');">Demander la fermeture de mon compte</a>

                <br/>
                <h3 style="margin-top:10px">Mes préférences</h3>
                @include('espace_client.paiement_relais', [
                'paiement_selected' => $user->client->pref_paiement, 
                'relais_selected' => $user->client->pref_relais, 
                'prefrelais_not_lied' => false, 
                'prefpaiement_not_lied' => false, 
                'ref_livraison' => 0, 
                'par_defaut' => "par défaut", 
                'modespaiement' => $modes_actifs, 
                'relaiss' => $relais_actifs
                ])
            </div>

            <div class="panel-body col-md-10">
                <form id="commande_store" class="form-horizontal" role="form" method="POST" action="{{ route('commande.store') }}">
                {!! csrf_field() !!}
                    

                    <div class="les_livraisons_ouvertes">
                        @foreach($livraisons as $livraison)
                        <div class="une_livraison_ouverte">
                            @include('espace_client.une_livraison_ouverte')
                        </div>
                        @endforeach
                    </div>
                    <div class="commandes">
                        @if($commandes_en_cours->isEmpty() and $commandes_archived->isEmpty())
                            Aucune commande n’a été trouvée
                        @else
                            <!-- affichage des commandes en cours -->
                            @foreach($commandes_en_cours as $commande) 
                                <div class="une_commande" style="position:relative">
                                    @include('espace_client.une_commande')
                                </div>
                            @endforeach

                            <!-- affichage des commandes archivées -->
                            <div id="commandes_archived">
                                <div id="show_commandes_archived" class="btn btn-info" onClick="javascript:toggleCommandesArchived();" >Voir mes commandes archivées</div>
                                <div id="hide_commandes_archived" class="btn btn-info hidden" onClick="javascript:toggleCommandesArchived();" >Masquer mes commandes archivées</div>
                            </div>
                            @foreach($commandes_archived as $commande)  
                                <div id="une_commande_archived" class="hidden" style="position:relative">
                                    @include('espace_client.une_commande')
                                </div>
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
<script  type="text/javascript">var relais_lied = {!! $relais_lied !!}; var paiement_lied = {!! $paiement_lied !!};</script>
<script src="/js/espace_client.js"></script>
<script type="text/javascript">
window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
</script>
@endsection
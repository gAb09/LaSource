    @extends('layouts.app')

@section('content')

<div class="container espace_client">
    <div class="row">
        <div class="">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Espace client de {{$item->Client->prenom}} {{$item->Client->nom}}  ({{ $item->pseudo }})</h2>
                </div>

                <div class="panel-body">

                    <h3>Mes coordonnées</h3>
                    {{ $item->Client->prenom }} {{ $item->Client->nom }} ({{ $item->pseudo }})<br />
                    {{ $item->Client->ad1 }}<br />
                    {{ $item->Client->ad2 }}<br />
                    {{ $item->Client->cp }} {{ $item->Client->ville }}<br />
                    Tél : {{ $item->Client->tel }}<br />
                    Portable : {{ $item->Client->mobile }}<br />
                    Courriel : {{ $item->email }}<br />
                    Rôle : {{ $item->role->etiquette }}<br />
                    
                </div>
                <div class="panel-body">

                    <h3>Mes commandes</h3>
                    sfljdLJm<br />                    
                    dsf.,F=,fd=<br />                    
                    gEGdf,lg,<br />                    
                    F,f;,=é'tqgfhg<br />                    
                    v,;:c ;:,ùqfe<br />                    
                    fldflù  ù<br />                    
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
